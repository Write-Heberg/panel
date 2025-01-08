import React, { useEffect } from 'react';
import { CSSTransition } from 'react-transition-group';
import Spinner from '@/components/elements/Spinner';
import TrashcanRow from '@/components/server/files/TrashcanRow';
import FileManagerBreadcrumbs from '@/components/server/files/FileManagerBreadcrumbs';
import { useLocation } from 'react-router-dom';
import tw from 'twin.macro';
import { ServerContext } from '@/state/server';
import TrashcanMassActionsBar from '@/components/server/files/TrashcanMassActionsBar';
import ServerContentBlock from '@/components/elements/ServerContentBlock';
import { useStoreActions } from '@/state/hooks';
import ErrorBoundary from '@/components/elements/ErrorBoundary';
import { FileActionCheckbox } from '@/components/server/files/SelectFileCheckbox';
import { hashToPath } from '@/helpers';
import { FileObject } from '@/api/server/files/loadDirectory';
import useTrashcanSwr from '@/plugins/useTrashcanSwr';
import MessageBox from '@/components/MessageBox';
import { ServerError } from '@/components/elements/ScreenBlock';
import { httpErrorToHuman } from '@/api/http';
import { useTranslation } from 'react-i18next';

const sortFiles = (files: FileObject[]): FileObject[] => {
    const sortedFiles: FileObject[] = files
        .sort((a, b) => a.name.localeCompare(b.name))
        .sort((a, b) => (a.isFile === b.isFile ? 0 : a.isFile ? 1 : -1));
    return sortedFiles.filter((file, index) => index === 0 || file.name !== sortedFiles[index - 1].name);
};

export default () => {
    const { t } = useTranslation('arix/server/files');
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const { hash } = useLocation();
    const clearFlashes = useStoreActions((actions) => actions.flashes.clearFlashes);
    const directory = ServerContext.useStoreState((state) => state.files.directory);
    const setDirectory = ServerContext.useStoreActions((actions) => actions.files.setDirectory);

    const setSelectedFiles = ServerContext.useStoreActions((actions) => actions.files.setSelectedFiles);
    const selectedFilesLength = ServerContext.useStoreState((state) => state.files.selectedFiles.length);

    const { data: files, error, mutate } = useTrashcanSwr();

    useEffect(() => {
        clearFlashes('files');
        setSelectedFiles([]);
        setDirectory(hashToPath(hash));
    }, [hash]);

    useEffect(() => {
        mutate();
    }, [directory]);

    const onSelectAllClick = (e: React.ChangeEvent<HTMLInputElement>) => {
        setSelectedFiles(e.currentTarget.checked ? files?.map((file) => file?.name) || [] : []);
    };

    return (
        <ServerContentBlock title={t('file-manager')} showFlashKey={'files'}>
            <div css={tw`mb-5`}>
                <MessageBox type={'info'}>{t('info-trashcan')}</MessageBox>
                </div>
            <div css={tw`flex flex-wrap-reverse md:flex-nowrap justify-start mb-4`}>
                <ErrorBoundary>
                    <FileManagerBreadcrumbs
                        renderLeft={
                            <FileActionCheckbox
                                type={'checkbox'}
                                css={tw`mx-4`}
                                checked={selectedFilesLength === (files?.length === 0 ? -1 : files?.length)}
                                onChange={onSelectAllClick}
                            />
                        }
                    />
                </ErrorBoundary>
            </div>
            {error ? (
                <p css={tw`text-sm text-neutral-400 text-center`}>{t('nothing-trashcan')}</p>
            ) : !files ? (
                <Spinner size={'large'} centered />
            ) : (
                <>
                    {!files.length ? (
                        <p css={tw`text-sm text-neutral-400 text-center`}>{t('nothing-trashcan')}</p>
                    ) : (
                        <CSSTransition classNames={'fade'} timeout={150} appear in>
                            <div>
                                {files.length > 250 && (
                                    <div css={tw`rounded bg-yellow-400 mb-px p-3`}>
                                        <p css={tw`text-yellow-900 text-sm text-center`}>
                                            {t('directory-to-large-trashcan')}
                                        </p>
                                    </div>
                                )}
                                {sortFiles(files.slice(0, 250)).map((file) => (
                                    <TrashcanRow key={file.name} file={file} />
                                ))}
                                <TrashcanMassActionsBar directory={'/' + uuid} />
                            </div>
                        </CSSTransition>
                    )}
                </>
            )}
        </ServerContentBlock>
    );
};