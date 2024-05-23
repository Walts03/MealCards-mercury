<template>
  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 mt-20">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img class="mx-auto h-12 w-auto" :src="logo" alt="Your Company" />
      <h2
        class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900"
      >
        Create your account
      </h2>
    </div>
    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form @submit.prevent="register">
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
                autocomplete="new-password"
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
              Register
            </button>
          </div>
          <div v-if="msg" class="mt-4 text-red-500">{{ msg }}</div>
          <p class="mt-2 text-center text-sm text-gray-600">
            Already have an account?
            <router-link
              to="/login"
              class="font-medium text-lime-600 hover:text-lime-500"
              >Login</router-link
            >
          </p>
        </form>
      </div>
    </div>
    <Notification
      v-if="notification.visible"
      :message="notification.message"
      :type="notification.type"
    />
  </div>
</template>

<script>
import logo from "../assets/logo.png";
import Notification from "../components/Notification.vue";

export default {
  name: "Register",
  components: {
    Notification,
  },
  data() {
    return {
      msg: "",
      input: {
        username: "",
        password: "",
      },
      notification: {
        visible: false,
        message: "",
        type: "success", // success, error, etc.
      },
      logo, // Ensure you have this variable or update accordingly
    };
  },
  methods: {
    register() {
      if (this.validateForm()) {
        var self = this;
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

        fetch("resources/api_register.php/", requestOptions)
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              this.showNotification("Registration successful!", "success");
              setTimeout(() => {
                this.$router.replace({ name: "login" });
              }, 3000);
            } else {
              self.msg = data.message;
              this.showNotification(self.msg, "error");
            }
          })
          .catch((error) => {
            self.msg = "Error: " + error;
            this.showNotification(self.msg, "error");
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
    showNotification(message, type) {
      this.notification.message = message;
      this.notification.type = type;
      this.notification.visible = true;

      setTimeout(() => {
        this.notification.visible = false;
      }, 3000);
    },
  },
};
</script>
