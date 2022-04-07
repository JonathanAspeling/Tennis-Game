<template>
  <form @submit.prevent="submit">
    <div class="score-pannel">
      <label class="player-1-label" for="player_1">Player 1</label>
      <div class="pannels flex">
        <div class="flex-col space-x-4">
          <input id="player_1" v-model="form.player_1_score" />
          <div
            class="text-xs w-32 text-center text-red-700"
            v-if="form.errors.player_1_score"
          >
            {{ form.errors.player_1_score }}
          </div>
        </div>
        <div class="flex-col space-x-4">
          <input id="player_2" v-model="form.player_2_score" />
          <div
            class="text-xs w-32 text-center text-red-700"
            v-if="form.errors.player_2_score"
          >
            {{ form.errors.player_2_score }}
          </div>
        </div>
      </div>
      <label class="player-2-label" for="player_2">Player 2</label>
    </div>
    <br />
    <button class="submit-button" type="submit">Submit</button>
    <a
      class="underline text-indigo-600 block text-center mx-auto mt-4"
      href="/dashboard"
      >Reset</a
    >
  </form>
</template>

<script setup>
  import { reactive } from "vue";
  import { Inertia } from "@inertiajs/inertia";
  import { useForm } from "@inertiajs/inertia-vue3";

  const props = defineProps({
    game: Object,
  });

  const form = useForm({
    game_id: props.game?.id,
    player_1_score: props.game?.player_1_score,
    player_2_score: props.game?.player_1_score,
  });

  function submit() {
    form.post("/score-submit");
  }
</script>

<style scoped>
  .score-pannel {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    width: 100%;
  }

  .player-1-label {
    /*justify-content: flex-start;*/
    font-size: 3em;
    margin-right: -2em;
  }

  .player-2-label {
    /*justify-content: flex-end;*/
    font-size: 3em;
    margin-left: -2em;
  }

  #player_1,
  #player_2 {
    border: black;
    border-style: solid;
    text-align: center;
    margin-left: 1em;
    margin-right: 1em;
    width: 8em;
    height: 8em;
    border-radius: 25px;
  }

  .submit-button {
    border: green;
    border-radius: 25px;
    border-style: solid;
    padding: 1em;
    background: lightgreen;
    margin-left: auto;
    margin-right: auto;
    display: block;
    width: 14em;
  }
</style>
