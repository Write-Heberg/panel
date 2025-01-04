import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrash } from '@fortawesome/free-solid-svg-icons';
import React from 'react';
import { NavLink, useRouteMatch } from 'react-router-dom';
import tw from 'twin.macro';
import styled from 'styled-components/macro';
import useSWR from 'swr';
import getSize from '@/api/server/files/getTrashSize';
import { ServerContext } from '@/state/server';
import { bytesToString } from '@/lib/formatters';
import { differenceInHours, format, formatDistanceToNow } from 'date-fns';

const Row = styled.div`
    ${tw`flex bg-neutral-700 rounded-sm mb-px text-sm hover:text-neutral-100 cursor-pointer items-center no-underline hover:bg-neutral-600`};
`;

export interface TrashSizeResponse {
    size: number;
    last_deletion: Date;
}

const RowContents = () => {
    const match = useRouteMatch();

    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);

    const { data } = useSWR<TrashSizeResponse>([uuid, '/files/trashsize'], (key) => getSize(key), {
        revalidateOnFocus: false,
    });

    return (
        <NavLink
            to={`${match.url}/trashcan`}
            css={tw`flex flex-1 text-neutral-300 no-underline p-3 overflow-hidden truncate `}
        >
            <div css={tw`flex-none self-center text-neutral-400 ml-6 mr-4 text-lg pl-3`}>
                <FontAwesomeIcon icon={faTrash} />
            </div>
            <div css={tw`self-center flex-1 truncate`}>Recycle Bin</div>
            {data && data.size && data.last_deletion && (
                <>
                    <div css={tw`w-1/6 self-center text-right mr-4 hidden sm:block`}>{bytesToString(data.size)}</div>
                    <div
                        css={tw`w-1/5 self-center text-right mr-4 hidden md:block`}
                        title={new Date(data.last_deletion).toString()}
                    >
                        {Math.abs(differenceInHours(new Date(data.last_deletion), new Date())) > 48
                            ? format(new Date(data.last_deletion), 'MMM do, yyyy h:mma')
                            : formatDistanceToNow(new Date(data.last_deletion), { addSuffix: true })}
                    </div>
                </>
            )}
        </NavLink>
    );
};

const TrashcanRow = () => (
    <Row
        onContextMenu={(e) => {
            e.preventDefault();
        }}
    >
        <RowContents />
    </Row>
);

export default TrashcanRow;