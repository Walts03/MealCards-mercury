<template>
  <div class="pt-32 bg-lime-wave">
    <h1 class="title text-center">Discover New Flavors Daily</h1>
    <div
      class="tab-menu flex flex-wrap items-center overflow-x-auto overflow-y-hidden py-10 justify-center text-gray-800"
    >
      <p class="subtitle flex items-center flex-shrink-0 px-5 py-3">
        Explore a World of Culinary Delights
      </p>
    </div>
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
  meals.value = []; // Clear previous meals
  for (let i = 0; i < 9; i++) {
    await axiosClient.get(`random.php`).then(({ data }) => {
      if (data && data.meals) {
<<<<<<< HEAD
        meals.value.push(data.meals[0]);
=======
        meals.value.push(data.meals[0]); // Assuming response has a 'meals' array
>>>>>>> 03c21f29a8c4cb8d818eb4720a35bf69bd4c35b5
      }
    });
  }
});
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@300;700&display=swap");

.bg-lime-wave {
  background: linear-gradient(-45deg, #efffcd, #a7e9af, #f7ffe6, #d4f8e8);
  background-size: 400% 400%;
  animation: limeWave 16s ease infinite;
}

.title {
  color: #4a772f;
  font-family: "Montserrat", sans-serif;
  font-size: 2.5rem;
  font-weight: 600;
  text-shadow: 1px 1px 4px rgba(255, 255, 255, 0.7);
  animation: fadeIn 2s ease-out;
}

.subtitle {
  color: #424242;
  font-family: "Montserrat", sans-serif;
  font-size: 1.25rem;
  font-weight: 600;
  background: rgba(255, 255, 255, 0.9);
  border-radius: 10px;
  animation: fadeIn 2s ease-out 1s;
}

@keyframes limeWave {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>
