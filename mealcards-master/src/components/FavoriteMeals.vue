<template>
  <div class="mt-20 container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-7 text-center">Your Favorite Meals</h2>
    <div v-if="favoriteMealsDetails.length === 0" class="text-center">
      <p>You have no favorite meals.</p>
    </div>
<<<<<<< HEAD
    <div v-else>
      <div class="table-responsive">
        <table class="min-w-full bg-white border border-gray-300">
          <thead class="thead-non-mobile">
            <tr>
              <th class="py-2 px-4 border-b">No.</th>
              <th class="py-2 px-4 border-b">Image</th>
              <th class="py-2 px-4 border-b">Name</th>
              <th class="py-2 px-4 border-b">Area</th>
              <th class="py-2 px-4 border-b">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(meal, index) in favoriteMealsDetails"
              :key="meal.idMeal"
              class="mobile-card"
            >
              <td data-label="No." class="py-2 px-4 border-b text-center">
                {{ index + 1 }}
              </td>
              <td data-label="Image" class="py-2 px-4 border-b text-center">
                <router-link
                  v-if="meal.idMeal"
                  :to="{ name: 'mealDetails', params: { id: meal.idMeal } }"
                >
                  <img
                    :src="meal.strMealThumb"
                    :alt="meal.strMeal"
                    class="object-cover inline-block rounded-full"
                    style="width: 80px; height: 80px"
                  />
                </router-link>
                <div v-else>
                  <div role="status">
                    <svg
                      aria-hidden="true"
                      class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-500"
                      viewBox="0 0 100 101"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor"
                      />
                      <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill"
                      />
                    </svg>
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              </td>
              <td data-label="Name" class="py-2 px-4 border-b text-center">
                {{ meal.strMeal }}
              </td>
              <td data-label="Area" class="py-2 px-4 border-b text-center">
                {{ meal.strArea }}
              </td>
              <td data-label="Actions" class="py-2 px-4 border-b text-center">
                <button
                  v-if="meal.idMeal"
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
=======
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
>>>>>>> 03c21f29a8c4cb8d818eb4720a35bf69bd4c35b5
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

<<<<<<< HEAD
.table-responsive {
  overflow-x: auto;
}

.thead-non-mobile th {
  min-width: 120px;
}

@media (max-width: 640px) {
  .thead-non-mobile {
    display: none; /* Hide the table header on small screens */
  }

  .mobile-card {
    display: block; /* Make each table row a block */
    margin-bottom: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Card-like appearance */
  }

  .mobile-card td {
    display: block; /* Stack the cells */
    text-align: right;
    padding-left: 50%; /* Make room for labels */
    position: relative;
  }

  .mobile-card td::before {
    content: attr(data-label); /* Display the column label */
    position: absolute;
    left: 10px;
    width: 45%; /* Label width */
    padding-right: 10px; /* Right padding */
    white-space: nowrap; /* Keep label on one line */
    text-align: left;
    font-weight: bold;
=======
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
>>>>>>> 03c21f29a8c4cb8d818eb4720a35bf69bd4c35b5
  }
}
</style>
