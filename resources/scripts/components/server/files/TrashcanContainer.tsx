import React, { useEffect, useState } from 'react';
import { ServerContext } from '@/state/server';
import ServerContentBlock from '@/components/elements/ServerContentBlock';
import { httpErrorToHuman } from '@/api/http';
import MessageBox from '@/components/MessageBox';
import deleteFiles from '@/api/server/files/deleteFiles';
import SpinnerOverlay from '@/components/elements/SpinnerOverlay';
import tw from 'twin.macro';
import http from '@/api/http';

interface FileObject {
    name: string;
    size: number;
    file: boolean;
}

export default () => {
    const uuid = ServerContext.useStoreState(state => state.server.data!.uuid);
    const [files, setFiles] = useState<FileObject[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        loadFiles();
    }, []);

    const loadFiles = () => {
        setLoading(true);
        setError('');
        
        http.get(`/api/client/servers/${uuid}/files/list-directory`, {
            params: {
                directory: `/${uuid}`
            },
        })
            .then(({ data }) => {
                setFiles(data.data);
            })
            .catch(error => {
                console.error(error);
                setError(httpErrorToHuman(error));
            })
            .finally(() => setLoading(false));
    };

    const handleRestore = async (file: FileObject) => {
        try {
            setLoading(true);
            await http.post(`/api/client/servers/${uuid}/files/restore`, {
                files: [file.name]
            });
            
            loadFiles();
        } catch (error) {
            console.error(error);
            setError(httpErrorToHuman(error));
        } finally {
            setLoading(false);
        }
    };
    
    const handleDelete = async (file: FileObject) => {
        try {
            setLoading(true);
            await deleteFiles(uuid, `/${uuid}`, [file.name], true);
            
            loadFiles();
        } catch (error) {
            console.error(error);
            setError(httpErrorToHuman(error));
        } finally {
            setLoading(false);
        }
    };

    return (
        <ServerContentBlock title={'File Manager'} showFlashKey={'files'}>
            <div css={tw`mb-5`}>
                <MessageBox type={'info'}>
                    Les fichiers et dossiers dans votre corbeille seront supprimés après 24 heures, après quoi vous ne pourrez plus les récupérer.
                </MessageBox>
            </div>
            <SpinnerOverlay visible={loading} />
            {error && (
                <div css={tw`mb-4`}>
                    <MessageBox type={'error'}>
                        {error}
                    </MessageBox>
                </div>
            )}
            <div css={tw`bg-neutral-700 rounded shadow-md`}>
                {files.length === 0 ? (
                    <p css={tw`p-6 text-center text-neutral-300`}>
                        La corbeille est vide.
                    </p>
                ) : (
                    <table css={tw`w-full`}>
                        <thead css={tw`bg-neutral-900`}>
                            <tr>
                                <th css={tw`p-3 text-left`}>Nom</th>
                                <th css={tw`p-3 text-left`}>Taille</th>
                                <th css={tw`p-3 text-left`}>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {files.map((file, index) => (
                                <tr key={index} css={tw`border-b border-neutral-600 hover:bg-neutral-600`}>
                                    <td css={tw`p-3`}>{file.name}</td>
                                    <td css={tw`p-3`}>{file.size}</td>
                                    <td css={tw`p-3`}>
                                        <button 
                                            css={tw`mr-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded`}
                                            onClick={() => handleRestore(file)}
                                        >
                                            Restaurer
                                        </button>
                                        <button 
                                            css={tw`px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded`}
                                            onClick={() => handleDelete(file)}
                                        >
                                            Supprimer
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                )}
            </div>
        </ServerContentBlock>
    );
};