import React, { memo, useRef, useState } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrashRestore, faTrashAlt, IconDefinition, faEllipsisH } from '@fortawesome/free-solid-svg-icons';
import { ServerContext } from '@/state/server';
import deleteFiles from '@/api/server/files/deleteFiles';
import restoreFile from '@/api/server/files/restoreFile';
import Can from '@/components/elements/Can';
import useFlash from '@/plugins/useFlash';
import tw from 'twin.macro';
import DropdownMenu from '@/components/elements/DropdownMenu';
import styled from 'styled-components/macro';
import isEqual from 'react-fast-compare';
import ConfirmationModal from '@/components/elements/ConfirmationModal';
import { FileObject } from '@/api/server/files/loadDirectory';
import useTrashcanSwr from '@/plugins/useTrashcanSwr';
import { useTranslation } from 'react-i18next';

const StyledRow = styled.div<{ $danger?: boolean }>`
    ${tw`p-2 flex items-center rounded`};
    ${(props) =>
        props.$danger ? tw`hover:bg-red-100 hover:text-red-700` : tw`hover:bg-neutral-100 hover:text-neutral-700`};
`;

interface RowProps extends React.HTMLAttributes<HTMLDivElement> {
    icon: IconDefinition;
    title: string;
    $danger?: boolean;
}

const Row = ({ icon, title, ...props }: RowProps) => (
    <StyledRow {...props}>
        <FontAwesomeIcon icon={icon} css={tw`text-xs`} fixedWidth />
        <span css={tw`ml-2`}>{title}</span>
    </StyledRow>
);

const FileDropdownMenu = ({ file }: { file: FileObject }) => {
    const onClickRef = useRef<DropdownMenu>(null);
    const [showConfirmation, setShowConfirmation] = useState(false);
    const { t } = useTranslation('arix/server/files');
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const { clearAndAddHttpError, clearFlashes } = useFlash();
    const { mutate } = useTrashcanSwr();

    const doDeletion = () => {
        clearFlashes('files');

        deleteFiles(uuid, '/' + uuid, [file.name], true)
            .catch((error) => {
                clearAndAddHttpError({ key: 'files', error });
            })
            .then(() => {
                setShowConfirmation(false);
                mutate();
            });
    };

    const doRestore = () => {
        clearFlashes('files');

        restoreFile(uuid, '/' + uuid, [file.name])
            .catch((error) => {
                clearAndAddHttpError({ key: 'files', error });
            })
            .then(() => mutate());
    };

    return (
        <>
            <ConfirmationModal
                visible={showConfirmation}
                title={file.isFile ? t('display-card-dropdown-delete-file') : t('display-card-dropdown-delete-directory')}
                buttonText={file.isFile ? t('display-card-confirm-delete-file-trashcan') : t('display-card-confirm-delete-directory-trashcan')}
                onConfirmed={doDeletion}
                onModalDismissed={() => setShowConfirmation(false)}
            >
                {t('display-permanent-delete-warning-into-trashcan')}
            </ConfirmationModal>
            <DropdownMenu
                ref={onClickRef}
                renderToggle={(onClick) => (
                    <div css={tw`px-4 py-2 hover:text-white cursor-pointer`} onClick={onClick}>
                        <FontAwesomeIcon icon={faEllipsisH} />
                    </div>
                )}
            >
                <Can action={'file.update'}>
                    <Row onClick={doRestore} icon={faTrashRestore} title={t('display-dropdown-restore-trashcan')} />
                </Can>
                <Can action={'file.delete'}>
                    <Row onClick={() => setShowConfirmation(true)} icon={faTrashAlt} title={t('display-dropdown-delete-trashcan')} $danger />
                </Can>
            </DropdownMenu>
        </>
    );
};

export default memo(FileDropdownMenu, isEqual);