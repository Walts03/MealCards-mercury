<template>
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 mt-20">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img class="mx-auto h-12 w-auto" :src="logo" alt="Your Company" />
      <h2
        class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
      >
        Sign in to your account
      </h2>
    </div>
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form @submit.prevent="login">
          <div>
            <label
              for="username"
              class="block text-sm font-medium text-gray-700"
              >Username</label
            >
            <div class="mt-1">
              <input
                v-model="input.username"
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-lime-500 focus:border-lime-500 sm:text-sm"
                required
              />
            </div>
          </div>
          <div class="mt-4">
            <label
              for="password"
              class="block text-sm font-medium text-gray-700"
              >Password</label
            >
            <div class="mt-1">
              <input
                v-model="input.password"
                type="password"
                autocomplete="current-password"
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-lime-500 focus:border-lime-500 sm:text-sm"
                required
              />
            </div>
          </div>
          <div class="mt-6">
            <button
              type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500"
            >
              Sign in
            </button>
          </div>
          <div v-if="msg" class="mt-4 text-red-500">{{ msg }}</div>
          <p class="mt-2 text-center text-sm text-gray-600">
            Don't have an account?
            <router-link
              to="/register"
              class="font-medium text-lime-600 hover:text-lime-500"
              >Sign up</router-link
            >
          </p>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import logo from "../assets/logo.png";
import { mapActions } from "vuex";

export default {
  name: "Login",
  data() {
    return {
      msg: "",
      input: {
        username: "",
        password: "",
      },
      logo,
    };
  },
  methods: {
    ...mapActions({
      loginAction: "login",
    }),
    login() {
      if (this.validateForm()) {
        const requestOptions = {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            username: this.input.username,
            password: this.input.password,
          }),
        };

        fetch("resources/api_user.php/", requestOptions)
          .then((response) => response.json())
          .then((data) => {
            console.log("API response:", data); // Log the API response
            if (data && data.success) {
              this.loginAction(data.user)
                .then(() => {
                  console.log("User logged in:", data.user); // Log user data
                  this.$router.replace({ name: "home" });
                })
                .catch((err) => {
                  console.error("Login error:", err);
                  this.msg = "Login failed. Please try again.";
                });
            } else {
              this.msg = data
                ? data.message
                : "Login failed. Please check your username and password.";
            }
          })
          .catch((error) => {
            this.msg = "Error: " + error;
          });
      }
    },
    validateForm() {
      if (!this.input.username) {
        this.msg = "Username is required";
        return false;
      }
      if (this.input.username.length > 10) {
        this.msg = "Username must be less than 10 characters";
        return false;
      }
      if (!this.input.password) {
        this.msg = "Password is required";
        return false;
      }
      if (this.input.password.length < 8) {
        this.msg = "Password must be more than 8 characters";
        return false;
      }
      return true;
    },
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
