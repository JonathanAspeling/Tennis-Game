<template>
  <form @submit.prevent="submit">
    <div class="score-pannel">
      <label class="player-1-label" for="player_1">Player 1</label>
      <div class="pannels">
        <input id="player_1" v-model="form.player_1_score"/>
        <input id="player_2" v-model="form.player_2_score"/>
      </div>
      <label class="player-2-label" for="player_2">Player 2</label>
    </div>
    <br>
    <button class="submit-button" type="submit">Submit</button>
  </form>
</template>

<script>
import {reactive} from 'vue'
import {Inertia} from '@inertiajs/inertia'

export default {
  setup() {
    const form = reactive({
      first_name: null,
      last_name: null,
    })

    function submit() {
      Inertia.post('/users', form)
    }

    return {form, submit}
  },
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

#player_1, #player_2 {
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