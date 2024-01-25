import http from '@/api/http';

export default (uuid: string, directory: string, files: string[], perm?: boolean): Promise<void> => {
    return new Promise((resolve, reject) => {
        http.post(`/api/client/servers/${uuid}/files/delete`, { root: directory, files, perm })
            .then(() => resolve())
            .catch(reject);
    });
};
