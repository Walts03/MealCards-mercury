<template>
  <div class="p-8 pb-0 mt-20">
    <label
      for="default-search"
      class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
      >Search</label
    >
    <div class="relative">
      <div
        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
      >
        <svg
          class="w-4 h-4 text-gray-500 dark:text-gray-400"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 20 20"
        >
          <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
          />
        </svg>
      </div>
      <input
        type="text"
        id="default-search"
        v-model="keyword"
        @change="searchMeals"
        class="block w-full p-4 ps-10 text-sm text-black border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:border-gray-600 dark:placeholder-gray-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500"
        placeholder="Search for Meals"
      />
      <button
        type="submit"
        class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
      >
        Search
      </button>
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
import { computed, ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import store from "../store";
import MealItem from "../components/MealItem.vue";
import PaginateControl from "../components/PaginateControl.vue";

const route = useRoute();
const keyword = ref("");

const paginatedMeals = computed(() => {
  const start =
    (store.state.pagination.currentPage - 1) * store.state.pagination.pageSize;
  const end = start + store.state.pagination.pageSize;
  return store.state.searchedMeals.slice(start, end);
});

const pagination = computed(() => store.state.pagination);

function searchMeals() {
  if (keyword.value) {
    store.dispatch("searchMeals", keyword.value);
  } else {
    store.commit("setSearchedMeals", []);
  }
}

function changePage(page) {
  if (
    page > 0 &&
    page <= Math.ceil(pagination.value.totalItems / pagination.value.pageSize)
  ) {
    store.commit("setCurrentPage", page);
  }
}

onMounted(() => {
  keyword.value = route.params.name || "";
  if (keyword.value) {
    searchMeals();
  }
});
</script>
