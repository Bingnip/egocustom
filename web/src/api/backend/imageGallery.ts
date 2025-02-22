import createAxios from '/@/utils/axios'

export const url = '/admin/routine.Gallery/'
export const galleryUrl = '/admin/routine.Attachment/'
export const actionUrl = new Map([['del', galleryUrl + 'del']])

export function getGalleryList(params: anyObj = {}) {
    return createAxios({
        url: url + 'getGalleryAll',
        method: 'post',
        params: params,
    })
}

export function renameImgSubmit(params: anyObj = {}) {
    return createAxios({
        url: url + 'renameImgSubmit',
        method: 'post',
        data: params,
    })
}

export function deleteImage(ids: string[]) {
    return createAxios(
        {
            url: actionUrl.get('del'),
            method: 'DELETE',
            params: {
                ids: ids,
            },
        },
        {
            showSuccessMessage: true,
        }
    )
}

export function moveImage(folderId: number, ids: string[]) {
    return createAxios({
        url: url + 'moveImage',
        method: 'post',
        data: { folderId, ids },
    })
}
