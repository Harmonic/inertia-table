<template>
  <span>
    <h1 class="mb-8 font-bold text-3xl">@plural</h1>
    
    <inertia-table 
      :data="@pluralNameLowercase" 
      id="id" 
      :order="order" 
      :filters="filters" 
      :columns="columns" 
      routeName="@pluralNameLowercase" 
      createLink="@pluralNameLowercase.create" 
      @item-selected="show">
    </inertia-table>
    
  </span>
</template>

<script>
import InertiaTable from 'inertia-table'

export default {
  components: {
    InertiaTable
  },
  props: {
    @pluralNameLowercase: Array,
    filters: Object,
    order: Object,
  },
  data() {
    return {
      columns: [@columns],
    }
  },
  methods: {
    show(@modelLowercase) {
      this.$inertia.replace(this.route('@pluralNameLowercase.edit', @modelLowercase.id));
    }
  },
}
</script>
