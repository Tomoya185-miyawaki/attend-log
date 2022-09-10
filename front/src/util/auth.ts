/**
 * ログイン判定
 * @return {boolean} ログインしているかどうかの結果
 */
export function isAdminLoggedIn() {
  const isAdminAuth = (localStorage.getItem('adminAuth') === 'true') ? true : false
  if (isAdminAuth) {
    return true
  }
  return false
}

/**
 * API通信の結果で401が帰った時にログアウトする
 * @param {string} status ステータスコード
 */
export function failedApiAfterLogout(status: number) {
  if (status === 401) {
    localStorage.setItem('adminAuth', 'false')
  }
}