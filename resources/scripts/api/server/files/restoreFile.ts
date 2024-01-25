import http from '@/api/http';

export default (uuid: string, directory: string, files: string[]): Promise<any> => {
    return new Promise((resolve, reject) => {
        http.post(`/api/client/servers/${uuid}/files/restore`, {root: directory, files}).then((data) => {
            resolve(data.data || []);
        }).catch(reject);
    });
};