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
        <option value="prix-asc">Les moins chers</option>
        <option value="prix-desc">Les plus chers</option>
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

.sort-bloc select {
  background-color: var(--light);
  border: 2px solid #ccc;
  border-radius: 25px;
  display: inline-block;
  line-height: 1.5em;
  font-family: "Ubuntu", "Roboto", sans-serif;
  padding: 0.5em 3.5em 0.5em 1em;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  -webkit-appearance: none;
  -moz-appearance: none;
}

.sort-bloc select {
  background-image:
    linear-gradient(45deg, transparent 50%, #ccc 50%),
    linear-gradient(135deg, #ccc 50%, transparent 50%),
    linear-gradient(to right, #ccc, #ccc);
  background-position:
    calc(100% - 20px) calc(1em + 2px),
    calc(100% - 15px) calc(1em + 2px),
    calc(100% - 2.5em) 0.5em;
  background-size:
    5px 5px,
    5px 5px,
    1px 1.5em;
  background-repeat: no-repeat;
}

.sort-bloc select:focus {
  background-image:
    linear-gradient(45deg, var(--secondary) 50%, transparent 50%),
    linear-gradient(135deg, transparent 50%, var(--secondary) 50%),
    linear-gradient(to right, #ccc, #ccc);
  background-position:
    calc(100% - 15px) 1em,
    calc(100% - 20px) 1em,
    calc(100% - 2.5em) 0.5em;
  background-size:
    5px 5px,
    5px 5px,
    1px 1.5em;
  background-repeat: no-repeat;
  border-color: var(--secondary);
  outline: 0;
}
</style>