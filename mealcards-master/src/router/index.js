import { createRouter, createWebHashHistory } from "vue-router";
import DefaultLayout from "../components/DefaultLayout.vue";
import Login from "../components/Login.vue";
import Home from "../views/Home.vue";
import SearchByIngredient from "../views/SearchByIngredient.vue";
import SearchByName from "../views/SearchByName.vue";
import SearchByLetter from "../views/SearchByLetter.vue";
import MealDetails from "../views/MealDetails.vue";
import Ingredients from "../views/Ingredients.vue";
import Register from "../components/Register.vue";
import store from "../store";
import UnauthenticatedLayout from "../components/UnauthenticatedLayout.vue";
import FavoriteMeals from "../components/FavoriteMeals.vue";
const routes = [
  {
    path: "/",
    component: DefaultLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: "/",
        name: "home",
        component: Home,
      },
      {
        path: "/by-name/:name?",
        name: "byName",
        component: SearchByName,
      },
      {
        path: "/by-letter/:letter?",
        name: "byLetter",
        component: SearchByLetter,
      },
      {
        path: "/ingredients",
        name: "ingredients",
        component: Ingredients,
      },
      {
        path: "/by-ingredient/:ingredient",
        name: "byIngredient",
        component: SearchByIngredient,
      },
      {
        path: "/meal/:id",
        name: "mealDetails",
        component: MealDetails,
      },
      {
        path: "/favorites",
        name: "favorites",
        component: FavoriteMeals,
      },
    ],
  },
  {
    path: "/login",
    component: UnauthenticatedLayout,
    children: [
      {
        path: "",
        name: "login",
        component: Login,
      },
    ],
  },
  {
    path: "/register",
    component: UnauthenticatedLayout,
    children: [
      {
        path: "",
        name: "register",
        component: Register,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const publicPages = ["/", "/login", "/register", "/ingredients"];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = store.getters.isAuthenticated;
  console.log("Navigating to:", to.path);
  console.log("Auth required:", authRequired, "Logged in:", !!loggedIn);

  if (authRequired && !loggedIn) {
    console.log("Redirecting to login");
    next("/login");
  } else {
    next();
  }
});

export default router;
