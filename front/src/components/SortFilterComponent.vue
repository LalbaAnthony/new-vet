<template>
  <div class="sort-filter-bloc">
    <!-- Filtres -->
    <div class="filter-bloc">
      Filtres
    </div>
    <!-- Trie -->
    <div class="sort-bloc">
      <select @change="console.log($event.target.value)">
        <option>Trier par</option>
        <option value="price-asc">Les moins chers</option>
        <option value="price-desc">Les plus chers</option>
        <option value="created_at-desc">Les plus récents</option>
        <option value="created_at-asc">Les plus anciens</option>
        <option value="name-asc">De A à Z</option>
        <option value="name-desc">De Z à A</option>
      </select>
    </div>
  </div>
</template>

<script setup>

</script>

<style scoped>
.sort-filter-bloc {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 2rem 0;
}
</style>