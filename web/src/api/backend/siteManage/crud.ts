import createAxios from '/@/utils/axios'

export const url = '/admin/siteManage.Index/'

export function getList() {
    return createAxios({
        url: url + 'getList',
        method: 'post',
    })
}
