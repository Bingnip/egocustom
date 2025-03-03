import createAxios from '/@/utils/axios'

export const url = '/admin/siteManage.CurrencyConfig/'

export function getList() {
    return createAxios({
        url: url + 'getList',
        method: 'post',
    })
}
