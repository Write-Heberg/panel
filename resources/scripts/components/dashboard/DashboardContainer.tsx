import React, { useEffect, useState } from 'react';
import { Server } from '@/api/server/getServer';
import { ApplicationStore } from '@/state';
import getServers from '@/api/getServers';
import ServerCard from '@/components/dashboard/ServerCard';
import ServerCardBanner from '@/components/dashboard/ServerCardBanner';
import ServerCardGradient from '@/components/dashboard/ServerCardGradient';
import Spinner from '@/components/elements/Spinner';
import PageContentBlock from '@/components/elements/PageContentBlock';
import useFlash from '@/plugins/useFlash';
import { useStoreState } from 'easy-peasy';
import { usePersistedState } from '@/plugins/usePersistedState';
import Switch from '@/components/elements/Switch';
import tw from 'twin.macro';
import useSWR from 'swr';
import { useLocation } from 'react-router-dom';
import { useTranslation } from 'react-i18next';
import Sortable from 'sortablejs';
import sortServer from '@/api/sortServer';

export default () => {
    const { t } = useTranslation('arix/dashboard');
    const { search } = useLocation();
    const defaultPage = Number(new URLSearchParams(search).get('page') || '1');
    const [page, setPage] = useState(!isNaN(defaultPage) && defaultPage > 0 ? defaultPage : 1);
    const { clearFlashes, clearAndAddHttpError } = useFlash();
    const uuid = useStoreState((state) => state.user.data!.uuid);
    const [showOnlyAdmin, setShowOnlyAdmin] = usePersistedState(`${uuid}:show_all_servers`, false);
    const serverRow = useStoreState((state: ApplicationStore) => state.settings.data!.arix.serverRow);

    const { data: servers, error, mutate } = useSWR(
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
        window.history.replaceState(null, document.title, `/${page <= 1 ? '' : `?page=${page}`}`);
    }, [page]);

    useEffect(() => {
        if (error) clearAndAddHttpError({ key: 'dashboard', error });
        if (!error) clearFlashes('dashboard');
    }, [error]);

    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    function SortableList() {
        const [sortableInstance, setSortableInstance] = useState<Sortable | null>(null);

        useEffect(() => {
            const el = document.getElementById('sortable-list');
            if (!sortableInstance && el && !isMobile) {
                const instance = Sortable.create(el, {
                    animation: 150,
                    ghostClass: 'dragging',
                    onEnd: (evt) => {
                        const uuid = evt.item.getAttribute('data-uuid');
                        if (uuid) {
                            sortServer(uuid, evt.oldIndex, evt.newIndex).then(() => {
                                mutate(); // Rafraîchit les données après le tri
                            });
                        } else {
                            console.error('Missing data-uuid on sortable item.');
                        }
                    },
                });
                setSortableInstance(instance);
            }
        }, [sortableInstance]);

        return (
            <>
                {!servers ? (
                    <Spinner centered size={'large'} />
                ) : (
                    <div id="sortable-list" className="grid lg:grid-cols-2 gap-4">
                        {servers.items.map((server, index) => (
                            <div
                                key={server.uuid}
                                data-uuid={server.uuid}
                                className="sortable-item"
                            >
                                {serverRow === 1 ? (
                                    <ServerCardGradient server={server} css={tw`mt-2`} />
                                ) : serverRow === 2 ? (
                                    <ServerCardBanner server={server} css={tw`mt-2`} />
                                ) : (
                                    <ServerCard server={server} css={tw`mt-2`} />
                                )}
                            </div>
                        ))}
                    </div>
                )}
            </>
        );
    }

    return (
        <PageContentBlock title={t('Dashboard')} showFlashKey={'dashboard'}>
            {!servers ? (
                <Spinner centered size={'large'} />
            ) : (
                <SortableList />
            )}
        </PageContentBlock>
    );
};
