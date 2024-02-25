function goToConfirm(path) {
  if (confirm("Êtes-vous sûr de vouloir quitter cette page ? (Les modifications non sauvegardées seront perdues)")) {
      window.location.href = path;
  }
}