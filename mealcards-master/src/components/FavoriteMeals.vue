<template>
  <div class="mt-20 container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-7 text-center">Your Favorite Meals</h2>
    <div v-if="favoriteMealsDetails.length === 0" class="text-center">
      <p>You have no favorite meals.</p>
    </div>
    <div v-else class="responsive-table">
      <table class="w-full bg-white border border-gray-300">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b">No.</th>
            <th class="py-2 px-4 border-b">Image</th>
            <th class="py-2 px-4 border-b">Name</th>
            <th class="py-2 px-4 border-b">Area</th>
            <th class="py-2 px-4 border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(meal, index) in favoriteMealsDetails" :key="meal.idMeal">
            <td class="py-2 px-4 border-b text-center">{{ index + 1 }}</td>
            <td class="py-2 px-4 border-b text-center">
              <router-link
                :to="{ name: 'mealDetails', params: { id: meal.idMeal } }"
              >
                <img
                  :src="meal.strMealThumb"
                  :alt="meal.strMeal"
                  class="w-16 h-16 object-cover inline-block"
                />
              </router-link>
            </td>
            <td class="py-2 px-4 border-b text-center">{{ meal.strMeal }}</td>
            <td class="py-2 px-4 border-b text-center">{{ meal.strArea }}</td>
            <td class="py-2 px-4 border-b text-center">
              <button
                @click="removeFavorite(meal.idMeal)"
                class="bg-red-500 text-white px-2 py-1 rounded-full"
              >
                Remove
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from "vue";
import { useStore } from "vuex";

// Use Vuex store
const store = useStore();

// Map Vuex state and actions
const favoriteMeals = computed(() => store.state.favoriteMeals);
const favoriteMealsDetails = computed(() => {
  return favoriteMeals.value
    .map((mealId) => store.state.mealDetails[mealId])
    .filter((meal) => meal !== undefined);
});

// Methods
const removeFavorite = (mealId) => {
  store.dispatch("deleteFavorite", mealId);
};

// Fetch favorites and their details when the component is mounted
onMounted(async () => {
  await store.dispatch("fetchFavorites");
  for (const mealId of favoriteMeals.value) {
    await store.dispatch("fetchMealDetails", mealId);
  }
});
</script>

<style scoped>
.container {
  max-width: 1200px;
}

.responsive-table {
  overflow-x: auto;
}

@media (max-width: 640px) {
  .table th,
  .table td {
    padding: 10px; /* Adjust padding */
    display: block; /* Stack the table cells */
    text-align: right;
  }

  .table th::before {
    float: left;
    content: attr(aria-label); /* Use aria-label to replicate the thead */
  }

  .table td::before {
    float: left;
    content: attr(aria-label);
  }

  .text-2xl {
    font-size: 1.5rem; /* Smaller font size for smaller screens */
  }
}
</style>
