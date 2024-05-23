<template>
  <div>
    <div
      class="flex justify-center space-x-2 p-4 bg-white shadow-lg rounded-lg mt-20"
    >
      <router-link
        :to="{ name: 'byLetter', params: { letter } }"
        v-for="letter in letters"
        :class="{
          'bg-blue-500 text-white': route.params.letter === letter,
        }"
        :key="letter"
      >
        {{ letter }}
      </router-link>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-8">
      <MealItem
        v-for="meal in paginatedMeals"
        :key="meal.idMeal"
        :meal="meal"
      ></MealItem>
    </div>
    <PaginateControl
      v-if="paginatedMeals.length > 0"
      :pageSize="pagination.pageSize"
      :totalItems="pagination.totalItems"
      @update:page="changePage"
    />
  </div>
</template>

<script setup>
import { computed, onMounted, watch } from "vue";
import { useRoute } from "vue-router";
import store from "../store";
import MealItem from "../components/MealItem.vue";
import PaginateControl from "../components/PaginateControl.vue";

const route = useRoute();
const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".split("");

const meals = computed(() => store.state.mealsByLetter);
const paginatedMeals = computed(() => {
  const start =
    (store.state.pagination.currentPage - 1) * store.state.pagination.pageSize;
  const end = start + store.state.pagination.pageSize;
  return meals.value.slice(start, end);
});

const pagination = computed(() => store.state.pagination);

watch(route, () => {
  if (route.params.letter) {
    store.dispatch("searchMealsByLetter", route.params.letter);
  }
});

function changePage(page) {
  if (
    page > 0 &&
    page <= Math.ceil(pagination.value.totalItems / pagination.value.pageSize)
  ) {
    store.commit("setCurrentPage", page);
  }
}

onMounted(() => {
  if (route.params.letter) {
    store.dispatch("searchMealsByLetter", route.params.letter);
  }
});
</script>
