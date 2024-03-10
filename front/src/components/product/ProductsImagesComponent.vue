<template>
  <div>
    <div class="darken-background" v-if="isMainOpen" @click="hideMainImage()"></div>
    <div class="main-display" v-if="isMainOpen">
      <img
        :src="props.images[indexImage]?.path && imageExists(URL_BACKEND_UPLOAD + props.images[indexImage].path) ? `${URL_BACKEND_UPLOAD}${props.images[indexImage].path}` : '/helpers/no-img-available.webp'"
        :alt="props.images[indexImage].alt || `Image de ${props.alt}`" class="main-display-image" />
      <button class="main-display-close" @click="hideMainImage">
        <IconX />
      </button>
    </div>
    <div v-if="props.images && props.images.length > 0">
      <div class="carousel">
        <img
          :src="props.images[indexImage]?.path && imageExists(URL_BACKEND_UPLOAD + props.images[indexImage].path) ? `${URL_BACKEND_UPLOAD}${props.images[indexImage].path}` : '/helpers/no-img-available.webp'"
          :alt="props.images[indexImage].alt || `Image de ${props.alt}`" class="carousel-main-image"
          @click="isMainOpen ? hideMainImage() : showMainImage()" />
        <ul class="carousel-other-images">
          <li v-for="(image, i) in props.images" :key="i">
            <img v-if="image.path && imageExists(URL_BACKEND_UPLOAD + image.path)"
              :src="`${URL_BACKEND_UPLOAD}${image.path}`" :alt=" image.alt || `Image de ${props.alt}`"
              @click="setCarouselImage(i)" :class="indexImage === i ? 'active' : ''">
          </li>
        </ul>
      </div>
    </div>
    <div v-else>
      <img src="/helpers/no-img-available.webp" alt="Aucun image de disponible" class="no-image" />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { imageExists } from '@/helpers/helpers.js'
import { URL_BACKEND_UPLOAD } from '@/config';
import IconX from '@/icons/IconX.vue'

// const mobile = isMobile()

const isMainOpen = ref(false)
const indexImage = ref(0)

const props = defineProps({
  images: {
    type: Array,
    required: true,
  },
  alt: {
    type: String,
    required: true,
  },
})

const setCarouselImage = (index) => {
  indexImage.value = index
}

const hideMainImage = () => {
  isMainOpen.value = false
}

const showMainImage = () => {
  isMainOpen.value = true
}

</script>

<style scoped>
/* CINEMA SCREEN */
@media (min-width: 1600px) {

  .carousel-main-image,
  .no-image {
    height: 350px;
  }

  .carousel {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    justify-content: space-between;
  }

  .carousel-other-images {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
}

/* DESKTOP */
@media (min-width: 1024px) and (max-width: 1599px) {

  .carousel-main-image,
  .no-image {
    height: 300px;
  }

  .carousel {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    justify-content: space-between;
  }

  .carousel-other-images {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {

  .carousel-main-image,
  .no-image {
    height: 250px;
  }

  .carousel {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .carousel-other-images {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    justify-content: space-between;
  }

}

/* MOBILE */
@media (max-width: 767px) {

  .carousel-main-image,
  .no-image {
    height: 250px;
  }

  .carousel {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  .carousel-other-images {
    display: flex;
    flex-direction: row;
    gap: 1rem;
    justify-content: space-between;
  }
}

.carousel-main-image,
.no-image {
  object-fit: cover;
}

.carousel-main-image {
  cursor: pointer;
}

.carousel-other-images img {
  object-fit: cover;
  height: 75px;
  width: 75px;
  cursor: pointer;
}

img {
  border-radius: 10px;
  border: 2px solid transparent;
  transition: border 0.3s ease;
}

img.active {
  border: 2px solid var(--dark);
}

/* ============= DISPLAY MAIN IMAGE STUFF ============= */

.darken-background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: inherit;
  background-color: rgba(0, 0, 0, 0.75);
  z-index: 999;
}

.main-display {
  background-color: var(--light);
  border-radius: 20px;
  width: 500px;
  max-width: 90%;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  box-shadow: 1px 1px 20px 1px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 1rem;
  padding: 2rem;
  z-index: 1000;
}

.main-display-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: cover;
}

button.main-display-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background-color: var(--dark);
  color: var(--light);
  border: none;
  border-radius: 50%;
  padding: 0.5rem;
  cursor: pointer;
}

button.main-display-close>svg {
  width: 20px;
  height: 20px;
  transform: translate(0, 2px);
}
</style>