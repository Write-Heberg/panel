import React, { useEffect, useState } from 'react';
import { Server } from '@/api/server/getServer';
import getServers from '@/api/getServers';
import ServerRow from '@/components/dashboard/ServerRow';
import Spinner from '@/components/elements/Spinner';
import PageContentBlock from '@/components/elements/PageContentBlock';
import useFlash from '@/plugins/useFlash';
import { useStoreState } from 'easy-peasy';
import { usePersistedState } from '@/plugins/usePersistedState';
import Switch from '@/components/elements/Switch';
import tw from 'twin.macro';
import useSWR from 'swr';
import { PaginatedResult } from '@/api/http';
import Pagination from '@/components/elements/Pagination';
import { useLocation } from 'react-router-dom';
import Sortable from 'sortablejs';
import sortServer from '@/api/sortServer';

export default () => {
    const { search } = useLocation();
    const defaultPage = Number(new URLSearchParams(search).get('page') || '1');

    const [page, setPage] = useState(!isNaN(defaultPage) && defaultPage > 0 ? defaultPage : 1);
    const { clearFlashes, clearAndAddHttpError } = useFlash();
    const uuid = useStoreState((state) => state.user.data!.uuid);
    const [showOnlyAdmin, setShowOnlyAdmin] = usePersistedState(`${uuid}:show_all_servers`, false);

    const { data: servers, error } = useSWR<PaginatedResult<Server>>(
        ['/api/client/servers', showOnlyAdmin, page],
        () => getServers({ page, type: showOnlyAdmin ? 'admin' : undefined })
    );


    useEffect(() => {
        if (!servers) return;
        if (servers.pagination.currentPage > 1 && !servers.items.length) {
            setPage(1);
        }
    }, [servers?.pagination.currentPage]);

    useEffect(() => {
        // Don't use react-router to handle changing this part of the URL, otherwise it
        // triggers a needless re-render. We just want to track this in the URL incase the
        // user refreshes the page.
        window.history.replaceState(null, document.title, `/${page <= 1 ? '' : `?page=${page}`}`);
    }, [page]);

    useEffect(() => {
        if (error) clearAndAddHttpError({ key: 'dashboard', error });
        if (!error) clearFlashes('dashboard');
    }, [error]);
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    function SortableList() {
        const [sortables, setSortables] = React.useState<Sortable | null>(null);
        React.useEffect(() => {
            if (!isMobile) {
                const el = document.getElementById('list');
                if (!sortables) {
                    if (el && !showOnlyAdmin) {
                        setSortables(Sortable.create(el, {
                            forceFallback: true,

                            onEnd: function (evt) {
                                sortServer(evt.item.getAttribute("href")!.substring(8), evt.oldIndex, evt.newIndex);
                            },
                        }))
                    }
                }
            }
        })
        return (
            <>
                {!servers ? (
                    <Spinner centered size={'large'}/>
                ) : (
                    <Pagination data={servers} onPageSelect={setPage}>
                        {({ items }) => (
                            items.length > 0 ? (
                                <div id="list">
                                    {items.map((server, index) => (
                                        <ServerRow
                                            key={server.uuid}
                                            server={server}
                                            css={tw`mt-2`}
                                        />
                                    ))}
                                </div>
                            ) : (
                                <p css={tw`text-center text-sm text-neutral-400`}>
                                    {showOnlyAdmin ?
                                        'There are no other servers to display.'
                                        :
                                        'There are no servers associated with your account.'
                                    }
                                </p>
                            )
                        )}
                    </Pagination>
                )}
            </>
        )
    }

    return (
        <PageContentBlock title={'Dashboard'} showFlashKey={'dashboard'}>
            <div css={tw`mb-2 flex justify-end items-center`}>
                <p css={tw`uppercase text-xs text-neutral-400 mr-2`}>
                    {showOnlyAdmin ? "Showing others' servers" : 'Showing your servers'}
                </p>
                <Switch
                    name={'show_all_servers'}
                    defaultChecked={showOnlyAdmin}
                    onChange={() => setShowOnlyAdmin((s) => !s)}
                />
            </div>
            <SortableList/>
        </PageContentBlock>
    );
};
