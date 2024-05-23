<template>
  <nav
    class="fixed top-0 left-0 z-20 w-full border-b border-gray-200 bg-white py-2.5 px-6 sm:px-4"
  >
    <div
      class="container mx-auto flex max-w-6xl flex-wrap items-center justify-between"
    >
      <a href="#" class="flex items-center">
        <img :src="logo" alt="Logo" class="mr-3 h-6 text-lime-500 sm:h-9" />
        <span class="self-center whitespace-nowrap text-xl font-semibold"
          >MealCards</span
        >
      </a>
      <button
        @click="toggleMenu"
        class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden focus:outline-none focus:ring-2 focus:ring-gray-200"
        aria-controls="navbar-sticky"
        aria-expanded="false"
      >
        <span class="sr-only">Open main menu</span>
        <svg
          class="w-6 h-6"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fill-rule="evenodd"
            d="M3 5h14a1 1 0 010 2H3a1 1 0 110-2zm0 4h14a1 1 0 010 2H3a1 1 0 110-2zm0 4h14a1 1 0 010 2H3a1 1 0 110-2z"
            clip-rule="evenodd"
          ></path>
        </svg>
      </button>
      <div
        :class="[
          'md:flex',
          'w-full',
          'md:w-auto',
          'items-center',
          'justify-between',
          'md:order-1',
          { hidden: !isMenuOpen },
        ]"
      >
        <ul
          class="mt-4 flex flex-col rounded-lg border border-gray-100 bg-gray-50 p-4 md:mt-0 md:flex-row md:space-x-8 md:border-0 md:bg-white md:text-sm md:font-medium"
        >
          <li>
            <router-link
              activeClass="text-lime-700"
              :to="{ name: 'home' }"
              class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
            >
              Home
            </router-link>
          </li>
          <li v-if="isAuthenticated">
            <router-link
              activeClass="text-lime-700"
              :to="{ name: 'byName' }"
              class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
            >
              Search
            </router-link>
          </li>
          <li v-if="isAuthenticated">
            <router-link
              activeClass="text-lime-700"
              :to="{ name: 'byLetter' }"
              class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
            >
              Letter
            </router-link>
          </li>
          <li v-if="isAuthenticated">
            <router-link
              activeClass="text-lime-700"
              :to="{ name: 'favorites' }"
              class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
            >
              Favorites
            </router-link>
          </li>
          <li>
            <router-link
              activeClass="text-lime-700"
              :to="{ name: 'ingredients' }"
              class="block rounded py-2 pl-3 pr-4 text-gray-700 hover:bg-gray-100 md:p-0 md:hover:bg-transparent md:hover:text-lime-700"
            >
              Ingredients
            </router-link>
          </li>
        </ul>
      </div>
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
      isMenuOpen: false,
    };
  },
  computed: {
    ...mapState({
      isAuthenticated: (state) => !!state.user,
    }),
  },
  methods: {
    ...mapActions(["logout"]),
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
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

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #333;
}

.navbar-brand .navbar-item img {
  max-height: 3rem;
}

.navbar-burger {
  display: none;
}

.navbar-menu {
  display: flex;
  flex-grow: 1;
  justify-content: flex-end;
}

.navbar-item {
  color: #fff;
  padding: 0.5rem 1rem;
}

.navbar-item:hover {
  background-color: #444;
}
@media (max-width: 768px) {
  .navbar-burger {
    display: block;
    cursor: pointer;
  }

  .navbar-menu {
    display: none;
    flex-direction: column;
    width: 100%;
  }

  .navbar-menu.is-active {
    display: flex;
  }

  .navbar-item {
    width: 100%;
    text-align: center;
  }
}
</style>
