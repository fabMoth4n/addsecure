<template>
  <div class="zadanie-testowe" data-app="true">
    <h1></h1>
    <Zadanie/>
  </div>
</template>

<script>
import Zadanie from '@/components/ZadanieTestowe.vue'

export default {
  name: 'ZadanieTestoweView',
  components: {
    Zadanie
  }
}
</script>