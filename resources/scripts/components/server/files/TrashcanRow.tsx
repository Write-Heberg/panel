import { FileObject } from '@/api/server/files/loadDirectory';
import SelectFileCheckbox from '@/components/server/files/SelectFileCheckbox';
import TrashDropdownMenu from '@/components/server/files/TrashDropdownMenu';
import { bytesToString } from '@/lib/formatters';
import { usePermissions } from '@/plugins/usePermissions';
import { ServerContext } from '@/state/server';
import { faFileAlt, faFolder } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { differenceInHours, format, formatDistanceToNow } from 'date-fns';
import React, { memo } from 'react';
import isEqual from 'react-fast-compare';
import { NavLink } from 'react-router-dom';
import tw from 'twin.macro';
import styles from './style.module.css';

const Clickable: React.FC<{ file: FileObject }> = memo(({ file, children }) => {
    const [canReadContents] = usePermissions(['file.read-content']);

    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);

    return !canReadContents || !file.isFile || (file.isFile && !file.isEditable()) ? (
        <div className={styles.details}>{children}</div>
    ) : (
        <NavLink className={styles.details} to={`/server/${uuid}/files/edit#/${uuid}/${file.name}`}>
            {children}
        </NavLink>
    );
}, isEqual);

const TrashcanRow = ({ file }: { file: FileObject }) => (
    <div className={styles.file_row} key={file.name}>
        <SelectFileCheckbox name={file.name} />
        <Clickable file={file}>
            <div css={tw`flex-none self-center text-neutral-400 ml-6 mr-4 text-lg pl-3`}>
                {file.isFile ? <FontAwesomeIcon icon={faFileAlt} /> : <FontAwesomeIcon icon={faFolder} />}
            </div>
            <div css={tw`flex-1 truncate`}>{file.name}</div>
            {file.isFile === true && (
                <div css={tw`w-1/6 text-right mr-4 hidden sm:block`}>
                    {file.size === 0 ? <>0 kB</> : <>{bytesToString(file.size)}</>}
                </div>
            )}
            <div css={tw`w-1/5 text-right mr-4 hidden md:block`} title={new Date(file.modifiedAt).toString()}>
                {Math.abs(differenceInHours(new Date(file.modifiedAt), new Date())) > 48
                    ? format(new Date(file.modifiedAt), 'MMM do, yyyy h:mma')
                    : formatDistanceToNow(new Date(file.modifiedAt), { addSuffix: true })}
            </div>
        </Clickable>
        <TrashDropdownMenu file={file} />
    </div>
);

export default memo(TrashcanRow);