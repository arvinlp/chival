<template>
  <div class="card-progress">
    <a v-if="dynomic == null" v-bind:href="url" class="card-progress-body">
      <div class="card-progress-header" v-if="$slots.header">
          <slot name="header">
          </slot>
      </div>
      <div class="progress" :class="computedClasses">
        <div class="progress-bar"
          :class="computedClasses"
          role="progressbar"
          :aria-valuenow="value"
          aria-valuemin="0"
          aria-valuemax="100"
          :style="`width: ${value}%;`">
        </div>
      </div>
    </a>
    <router-link v-else :to="dynomic" class="card-progress-body">
      <div class="card-progress-header" v-if="$slots.header">
          <slot name="header">
          </slot>
      </div>
      <div class="progress" :class="computedClasses">
        <div class="progress-bar"
          :class="computedClasses"
          role="progressbar"
          :aria-valuenow="value"
          aria-valuemin="0"
          aria-valuemax="100"
          :style="`width: ${value}%;`">
        </div>
      </div>
    </router-link>
  </div>
</template>

<script>
// console.error(params)
export default {

  name: 'CardProgress',

  props: {
    url: {
      type: String,
      description: "CardProgress Link"
    },
    dynomic: {
      type: Object,
      default:null,
      description: "CardProgress Link"
    },
    striped: {
      type: Boolean,
      description: "Whether progress is striped"
    },
    animated: {
      type: Boolean,
      description:
        "Whether progress is animated (works only with `striped` prop together)"
    },
    type: {
      type: String,
      default: "default",
      description: "Progress type (e.g danger, primary etc)"
    },
    value: {
      type: Number,
      default: 0,
      // validator: value => {
      //   return parseInt(value) >= 0 && parseInt(value) <= 100;
      // },
      description: "Progress value"
    }
  },
  computed: {
    computedMainClasses() {
      return [
        { [`bg-${this.type}`]: this.type }
      ];
    },
    computedClasses() {
      return [
        { "progress-bar-striped": this.striped },
        { "progress-bar-animated": this.animated },
        { [`bg-${this.type}`]: this.type }
      ];
    }
  }
};
</script>
