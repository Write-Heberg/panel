import http from '@/api/http';
import { TrashSizeResponse } from '@/components/server/files/Trashcan';

export default async (uuid: string): Promise<TrashSizeResponse> => {
    const { data } = await http.get(`/api/client/servers/${uuid}/files/trashsize`);
    return data.data || [];
};