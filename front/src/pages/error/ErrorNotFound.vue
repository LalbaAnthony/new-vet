<template>
  <div class="center">
    <span class="error">Erreur 404</span>
    <p><span class="gradient">Aucune</span> page trouvé</p>
    <div class="button-bloc">  
      <!-- <button class="button outline" @click="$router.go(-1)">Retour</button> -->
      <button class="button" @click="$router.push('/')">Accueil</button>
    </div>
  </div>
</template>

<script setup>

</script>

<style scoped>
.center {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 50vh;
}

.center span.error {
  font-size: 2rem;
  margin-bottom: 1rem;
}

.center p {
  font-size: 1rem;
  margin-bottom: 1rem;
}

.button-bloc {
  display: flex;
  gap: 1rem;
}

</style>