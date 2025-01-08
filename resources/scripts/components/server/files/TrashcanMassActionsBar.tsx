import React, { useEffect, useState } from 'react';
import tw from 'twin.macro';
import Button from '@/components/elements/Button';
import Fade from '@/components/elements/Fade';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrashRestore, faTrashAlt } from '@fortawesome/free-solid-svg-icons';
import SpinnerOverlay from '@/components/elements/SpinnerOverlay';
import useFlash from '@/plugins/useFlash';
import { ServerContext } from '@/state/server';
import ConfirmationModal from '@/components/elements/ConfirmationModal';
import deleteFiles from '@/api/server/files/deleteFiles';
import restoreFile from '@/api/server/files/restoreFile';
import useTrashcanSwr from '@/plugins/useTrashcanSwr';
import { useTranslation } from 'react-i18next';

const TrashcanMassActionsBar = ({ directory }: { directory: string }) => {
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const { t } = useTranslation('arix/server/files');
    const { mutate } = useTrashcanSwr();

    const { clearFlashes, clearAndAddHttpError } = useFlash();
    const [loading, setLoading] = useState(false);
    const [loadingMessage, setLoadingMessage] = useState('');
    const [showConfirm, setShowConfirm] = useState(false);
    const selectedFiles = ServerContext.useStoreState((state) => state.files.selectedFiles);
    const setSelectedFiles = ServerContext.useStoreActions((actions) => actions.files.setSelectedFiles);

    useEffect(() => {
        if (!loading) setLoadingMessage('');
    }, [loading]);

    const onClickRestore = () => {
        setLoading(true);
        clearFlashes('files');
        setLoadingMessage('Restoring files...');

        restoreFile(uuid, directory, selectedFiles)
            .then(() => {
                mutate();
                setSelectedFiles([]);
            })
            .catch((error) => {
                clearAndAddHttpError({ key: 'files', error });
            })
            .then(() => setLoading(false));
    };

    const onClickConfirmDeletion = () => {
        setLoading(true);
        setShowConfirm(false);
        clearFlashes('files');
        setLoadingMessage('Deleting files...');

        deleteFiles(uuid, directory, selectedFiles, true)
            .then(() => {
                mutate();
                setSelectedFiles([]);
            })
            .catch((error) => {
                clearAndAddHttpError({ key: 'files', error });
            })
            .then(() => setLoading(false));
    };

    return (
        <Fade timeout={75} in={selectedFiles.length > 0} unmountOnExit>
            <div css={tw`pointer-events-none fixed bottom-0 z-20 left-0 right-0 flex justify-center`}>
                <SpinnerOverlay visible={loading} size={'large'} fixed>
                    {loadingMessage}
                </SpinnerOverlay>
                <ConfirmationModal
                    visible={showConfirm}
                    title={t('recycle-questions-delete-file')}
                    buttonText={t('recycle-validation-delete-file')}
                    onConfirmed={onClickConfirmDeletion}
                    onModalDismissed={() => setShowConfirm(false)}
                >
                    <div>
                        {t('delete-confirmation-message', { count: selectedFiles.length })}
                        <br />
                        {t('delete-warning')}
                    </div>
                    <div css={tw`mt-4`}>
                        <code>
                            {selectedFiles.slice(0, 15).map((file) => (
                                <li key={file}>
                                    {file}
                                    <br />
                                </li>
                            ))}
                            {selectedFiles.length > 15 && (
                                <li>{t('additional-files', { count: selectedFiles.length - 15 })}</li>
                            )}
                        </code>
                    </div>
                </ConfirmationModal>
                <div css={tw`pointer-events-auto rounded p-4 mb-6`} style={{ background: 'rgba(0, 0, 0, 0.35)' }}>
                    <Button size={'xsmall'} css={tw`mr-4`} onClick={onClickRestore}>
                        <FontAwesomeIcon icon={faTrashRestore} css={tw`mr-2`} /> {t('display-restore-trashcan')}
                    </Button>
                    <Button size={'xsmall'} color={'red'} isSecondary onClick={() => setShowConfirm(true)}>
                        <FontAwesomeIcon icon={faTrashAlt} css={tw`mr-2`} /> {t('display-delete-trashcan')}
                    </Button>
                </div>
            </div>
        </Fade>
    );
};

export default TrashcanMassActionsBar;