<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head} from '@inertiajs/inertia-vue3';
import ScoreApp from "@/Components/ScoreApp";

</script>

<style>

</style>

<template>
  <Head title="Dashboard"/>

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <ScoreApp></ScoreApp>
            <div class="game-state">{{ GameState }}</div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>

import {onMounted} from "vue";

export default{
  data()
  {
    return {
      GameState: 'Pending'
    }
  },

  computed:{
    updateGameStateMessage(){
      this.GameState = this.$attrs['activeGame'].game_state;
    }
  },

  mounted() {
    this.GameState = this.$attrs['activeGame'].game_state;
  }
}

</script>

<style scoped>
.game-state{
  margin-top: 1.5em;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
  text-align: center;
  font-size: 2.5em;
}

</style>