import React, { useEffect, useState } from 'react';
import { ServerContext } from '@/state/server';
import { NavLink, useLocation, useRouteMatch } from 'react-router-dom';
import { encodePathSegments, hashToPath } from '@/helpers';
import tw from 'twin.macro';
import { useTranslation } from 'react-i18next';

interface Props {
    renderLeft?: JSX.Element;
    withinFileEditor?: boolean;
    isNewFile?: boolean;
}

export default ({ renderLeft, withinFileEditor, isNewFile }: Props) => {
    const { t } = useTranslation('arix/server/files');
    const [file, setFile] = useState<string | null>(null);
    const id = ServerContext.useStoreState((state) => state.server.data!.id);
    const directory = ServerContext.useStoreState((state) => state.files.directory);
    const match = useRouteMatch();
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const { hash } = useLocation();

    useEffect(() => {
        const path = hashToPath(hash);

        if (withinFileEditor && !isNewFile) {
            const name = path.split('/').pop() || null;
            setFile(name);
        }
    }, [withinFileEditor, isNewFile, hash]);

    const breadcrumbs = (): { name: string; path?: string }[] =>
        directory
            .split('/')
            .filter((directory) => !!directory)
            .map((directory, index, dirs) => {
                if (!withinFileEditor && index === dirs.length - 1) {
                    return { name: directory };
                }

                return { name: directory, path: `/${dirs.slice(0, index + 1).join('/')}` };
            });

    return (
        <div css={tw`flex flex-shrink-0 flex-grow-0 items-center text-sm text-neutral-500 overflow-x-hidden`}>
            {renderLeft || <div css={tw`w-12`} />}/<span css={tw`px-1 text-neutral-300`}>{t('home')}</span>/
            <NavLink to={`/server/${id}/files`} css={tw`px-1 text-neutral-200 no-underline hover:text-neutral-100`}>
                {t('container')}
            </NavLink>
            /
            {!breadcrumbs().some((item) => item.name === uuid) &&
    breadcrumbs().map((crumb, index) =>
        crumb.path ? (
            <React.Fragment key={index}>
                <NavLink
                    to={`/server/${id}/files#${encodePathSegments(crumb.path)}`}
                    css={tw`px-1 text-neutral-200 no-underline hover:text-neutral-100`}
                >
                    {crumb.name}
                </NavLink>
                /
            </React.Fragment>
        ) : (
            <span key={index} css={tw`px-1 text-neutral-300`}>
                {crumb.name}
            </span>
        )
    )}
{(match.url.endsWith('/files/trashcan') || breadcrumbs().some((item) => item.name === uuid)) && (
    <a css={tw`px-1 text-neutral-300`} href={`/server/${uuid}/files/trashcan`}>
        {t('display-name-trashcan')} {breadcrumbs().some((item) => item.name === uuid) && '/'}
    </a>
)}
            {file && (
                <React.Fragment>
                    <span css={tw`px-1 text-neutral-300`}>{file}</span>
                </React.Fragment>
            )}
        </div>
    );
};
