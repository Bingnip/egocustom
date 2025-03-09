import createAxios from '/@/utils/axios'

export const url = '/admin/siteManage.CurrencyConfig/'

export function getList() {
    return createAxios({ url: url + 'getList', method: 'post' })
}

export function removeRow(rowId: any) {
    const postData = { id: rowId }
    return createAxios({ url: url + 'removeRow', method: 'post', data: postData }, { showSuccessMessage: true })
}
