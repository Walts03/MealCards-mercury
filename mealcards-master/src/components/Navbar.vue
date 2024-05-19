<template>
  <nav
    class="fixed top-0 left-0 z-20 w-full border-b border-gray-200 bg-white py-2.5 px-6 sm:px-4"
  >
    <div
      class="container mx-auto flex max-w-6xl flex-wrap items-center justify-between"
    >
      <a href="#" class="flex items-center">
        <img
          :src="logo"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="mr-3 h-6 text-lime-500 sm:h-9"
        />
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"
        />
        <img />
        <span class="self-center whitespace-nowrap text-xl font-semibold"
          >MealCards</span
        >
      </a>
      <div class="mt-2 sm:mt-0 sm:flex md:order-2">
        <div v-if="isAuthenticated">
          <button
            type="button"
            @click="logoutUser"
            class="rounded mr-3 bg-lime-700 py-1.5 px-6 text-center text-sm font-medium text-white hover:bg-lime-800 focus:outline-none focus:ring-4 focus:ring-blue-300 md:mr-0 md:inline-block"
          >
            Log Out
          </button>
        </div>
        <div v-else>
          <router-link
            activeClass="bg-lime-700 text-white"
            to="/login"
            class="px-4 py-2 rounded-l-xl text-black m-0 hover:bg-neutral-300 transition"
          >
            Login
          </router-link>
          <router-link
            activeClass="bg-lime-700 text-white"
            to="/register"
            class="px-4 py-2 rounded-r-xl text-black m-0 hover:bg-neutral-300 transition"
          >
            Register
          </router-link>
        </div>
      </div>
      <div
        class="hidden w-full items-center justify-between md:order-1 md:flex md:w-auto"
        id="navbar-sticky"
      >
        <ul
          class="mt-4 flex flex-col rounded-lg border border-gray-100 bg-gray-50 p-4 md:mt-0 md:flex-row md:space-x-8 md:border-0 md:bg-white md:text-sm md:font-medium"
        >
          <li>
            <router-link
              activeClass="text-lime-700 "
              :to="{ name: 'home' }"
              class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
            >
              Home
            </router-link>
          </li>
          <div v-if="isAuthenticated">
            <li>
              <router-link
                activeClass="text-lime-700 "
                :to="{ name: 'byName' }"
                class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
              >
                Search
              </router-link>
            </li>
          </div>
          <div v-if="isAuthenticated">
            <li>
              <router-link
                activeClass="text-lime-700 "
                :to="{ name: 'byLetter' }"
                class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
              >
                Letter
              </router-link>
            </li>
          </div>
          <li>
            <router-link
              activeClass="text-lime-700 "
              v-if="isAuthenticated"
              class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
              :to="{ name: 'favorites' }"
              >Favorites</router-link
            >
          </li>
          <li>
            <router-link
              activeClass="text-lime-700 "
              :to="{ name: 'ingredients' }"
              class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
            >
              Ingredients
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapState, mapActions } from "vuex";
import logo from "../assets/logo.png";
export default {
  data() {
    return {
      logo,
    };
  },
  computed: {
    ...mapState({
      isAuthenticated: (state) => !!state.user,
    }),
  },
  methods: {
    ...mapActions(["logout"]),
    logoutUser() {
      console.log("Triggering logout...");
      this.logout()
        .then(() => {
          console.log("Logout successful");
          this.$router.replace({ name: "login" });
        })
        .catch((err) => {
          console.error("Logout error:", err);
        });
    },
  },
};
</script>
