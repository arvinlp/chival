<template>
  <section class="page">
    <div class="row">
      <CardProgress
        class="col-3"
        url="/users/new"
        type="default"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن پرسنل جدید</h5>
        </template>
      </CardProgress>
      <!-- -->
      <CardProgress
        class="col-3"
        url="/users/new"
        type="default"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن پرسنل جدید</h5>
        </template>
      </CardProgress>
      <!-- -->
      <CardProgress
        class="col-3"
        url="/users/new"
        type="default"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن پرسنل جدید</h5>
        </template>
      </CardProgress>
      <!-- -->
      <CardProgress
        class="col-3"
        url="/users/new"
        type="default"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن پرسنل جدید</h5>
        </template>
      </CardProgress>
      <!-- -->
    </div>
  </section>
</template>

<script>
import Body from "../../components/client/Body";
import CardProgress from "../../components/CardProgress";

export default {
  data() {
    return {};
  },

  components: {
    Body,
    CardProgress
  },

  computed: {},
  mounted() {
    this.api = "api/v1/client/dashboard";

    let promise = this.$http.get(this.$api(this.api + this.params));

    return promise
      .then(response => {
        const items = response.data;
        return items.data;
      })
      .catch(error => {
        return [];
      })
      .finally(() => (this.loading = false));
  },
  methods: {}
};
</script>