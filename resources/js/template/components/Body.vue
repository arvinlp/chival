<template>
  <div>
    <router-view name="header" />
    <router-view name="default" />
    <notifications group="warning" position="top center" />
    <notifications group="internal" position="top right" />
    <notifications group="dataGetter" position="bottom left" style="bottom:50px;" />
    <notifications group="error" style="margin-bottom:50px;" />
  </div>
</template>

<script>
export default {};
</script>

