<template>
  <div class="flex justify-center mt-4">
    <button
      v-for="page in pages"
      :key="page"
      @click="updatePage(page)"
      :class="{
        'bg-blue-500 text-white': currentPage === page,
        'bg-white text-black': currentPage !== page,
      }"
      class="mx-1 px-3 py-1 border rounded"
    >
      {{ page }}
    </button>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";

const props = defineProps({
  pageSize: {
    type: Number,
    required: true,
  },
  totalItems: {
    type: Number,
    required: true,
  },
});

const emit = defineEmits(["update:page"]);
const store = useStore();

const currentPage = computed(() => store.state.pagination.currentPage);
const totalPages = computed(() => Math.ceil(props.totalItems / props.pageSize));

const pages = computed(() => {
  let pagesArray = [];
  for (let i = 1; i <= totalPages.value; i++) {
    pagesArray.push(i);
  }
  return pagesArray;
});

function updatePage(page) {
  emit("update:page", page);
}
</script>

<style scoped>
.bg-white {
  background-color: white;
}
.bg-blue-500 {
  background-color: #4299e1;
}
.text-white {
  color: white;
}
.text-black {
  color: black;
}
.border {
  border: 1px solid #ccc;
}
.rounded {
  border-radius: 0.25rem;
}
</style>
