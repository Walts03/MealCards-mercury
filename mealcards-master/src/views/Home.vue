<template>
  <!-- Title -->
  <div class="pt-32 bg-white">
    <h1 class="text-center text-2xl font-bold text-gray-800">
      Random Meals of the Day
    </h1>
  </div>
  <!-- Tab Menu -->
  <div
    class="flex flex-wrap items-center overflow-x-auto overflow-y-hidden py-10 justify-center bg-white text-gray-800"
  >
    <p
      rel="noopener noreferrer"
      href="#"
      class="flex items-center flex-shrink-0 px-5 py-3 space-x-2 text-gray-600"
    >
      <span>Nourish Your Body, Delight Your Senses</span>
    </p>
  </div>
  <section class="py-10 bg-gray-100">
    <Meals :meals="meals" />
  </section>
  <Footer></Footer>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Footer from "../components/Footer.vue";
import Meals from "../components/Meals.vue";
import axiosClient from "../axiosClient.js";

const meals = ref([]);
onMounted(async () => {
  for (let i = 0; i < 9; i++) {
    axiosClient
      .get(`random.php`)
      .then(({ data }) => meals.value.push(data.meals[0]));
  }
});
</script>
