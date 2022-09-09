export function isAdminLoggedIn() {
  const isAdminAuth = (localStorage.getItem('adminAuth') === 'true') ? true : false
  if (isAdminAuth) {
    return true
  }
  return false
}