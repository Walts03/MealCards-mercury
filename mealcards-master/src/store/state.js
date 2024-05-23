export default {
  searchedMeals: [],
  mealsByLetter: [],
  mealsByIngredient: [],
  user: JSON.parse(localStorage.getItem("user")) || null,
  favoriteMeals: [],
  mealDetails: {},
  pagination: {
    pageSize: 9,
    currentPage: 1,
    totalItems: 0,
  },
};
