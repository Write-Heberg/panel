import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faFileAlt, faFolder } from '@fortawesome/free-solid-svg-icons';
import { bytesToString } from '@/lib/formatters';
import React, { memo } from 'react';
import tw from 'twin.macro';
import styled from 'styled-components/macro';
import SelectFileCheckbox from '@/components/server/files/SelectFileCheckbox';
import { differenceInHours, format, formatDistanceToNow } from 'date-fns';
import TrashDropdownMenu from '@/components/server/files/TrashDropdownMenu';
import { FileObject } from '@/api/server/files/loadDirectory';

const Row = styled.div`
    ${tw`flex bg-neutral-700 rounded-sm mb-px text-sm hover:text-neutral-100 cursor-pointer items-center no-underline hover:bg-neutral-600`};
`;

const TrashcanRow = ({ file }: { file: FileObject }) => (
    <Row
        key={file.name}
    >
        <SelectFileCheckbox name={file.name}/>
        <div css={tw`flex flex-1 text-neutral-300 no-underline p-3 overflow-hidden truncate`}>
            <div css={tw`flex-none self-center text-neutral-400 ml-6 mr-4 text-lg pl-3`}>
                {file.isFile ?
                    <FontAwesomeIcon icon={faFileAlt}/>
                    :
                    <FontAwesomeIcon icon={faFolder}/>
                }
            </div>
            <div css={tw`flex-1 truncate`}>
                {file.name}
            </div>
            {(file.isFile == true) &&
                <div css={tw`w-1/6 text-right mr-4 hidden sm:block`}>
                    {(file.size == 0) ?
                        <>0 kB</>
                    :
                        <>{bytesToString(file.size)}</>
                    }
                </div>
            }
            <div
                css={tw`w-1/5 text-right mr-4 hidden md:block`}
                title={new Date(file.modifiedAt).toString()}
            >
                {Math.abs(differenceInHours(new Date(file.modifiedAt), new Date())) > 48 ?
                    format(new Date(file.modifiedAt), 'MMM do, yyyy h:mma')
                    :
                    formatDistanceToNow(new Date(file.modifiedAt), { addSuffix: true })
                }
            </div>
            <TrashDropdownMenu file={file}/>
        </div>
    </Row>
);

export default memo(TrashcanRow);