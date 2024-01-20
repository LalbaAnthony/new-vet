<template>
  <div>
    <Carousel title="Notre séléction de produits" :products="products" :autoplay="'0'" />
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import Carousel from '@/components/ProductsCarouselComponent.vue'

const products = ref([])

function getProducts() {
  return [
    {
      image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
      categories: [
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
      ],
      name: 'Lorem ipsum dolor sit amet consectetur',
      description: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
      price: '9.99',
      stock: 684,
      slug: 'product1',
    },
    {
      image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
      categories: [
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
      ],
      name: 'Lorem ipsum dolor sit amet consectetur',
      description: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
      price: '9.99',
      stock: 684,
      slug: 'product1',
    },
    {
      image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
      categories: [
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
      ],
      name: 'Lorem ipsum dolor sit amet consectetur',
      description: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
      price: '9.99',
      stock: 684,
      slug: 'product1',
    },
    {
      image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
      categories: [
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
      ],
      name: 'Lorem ipsum dolor sit amet consectetur',
      description: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
      price: '9.99',
      stock: 684,
      slug: 'product1',
    },
    {
      image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
      categories: [
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
      ],
      name: 'Lorem ipsum dolor sit amet consectetur',
      description: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
      price: '9.99',
      stock: 684,
      slug: 'product1',
    },
    {
      image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
      categories: [
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
      ],
      name: 'Lorem ipsum dolor sit amet consectetur',
      description: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
      price: '9.99',
      stock: 684,
      slug: 'product1',
    },
    {
      image_path: 'https://img.freepik.com/free-photo/smiling-beautiful-young-woman-pink-mini-dress-posing-studio_155003-14602.jpg',
      categories: [
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
        {
          slug: 'vetements',
          libelle: 'Vêtements',
        },
      ],
      name: 'Lorem ipsum dolor sit amet consectetur',
      description: 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
      price: '9.99',
      stock: 684,
      slug: 'product1',
    },
  ]
}

onMounted(() => {
  products.value = getProducts()
})

</script>

<style scoped></style>
