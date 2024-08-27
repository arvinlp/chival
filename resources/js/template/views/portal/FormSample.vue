<template>
<section class="page">
  <div class="row">
    <b-col cols="12">
        <div class="inner-main">
            <div class="inner-header">
                <b-row>
                    <b-col cols="12">
                        <span>افزودن شرکت</span>
                    </b-col>
                </b-row>
            </div>
            <b-row class="inner-body row-eq-height">
                <b-col cols="12">
                  <b-form-group
                    id="input-group-1"
                    label="نام شرکت"
                    label-cols="2"
                    label-for="input-1"
                  >
                    <b-form-input
                      id="input-1"
                      v-model="form.name"
                      type="text"
                      required
                      placeholder="مشخصات صحیح را وارد کنید"
                    ></b-form-input>
                  </b-form-group>
                </b-col>
            </b-row>
        </div>
    </b-col>
    <b-col cols="6" class="text-right">
      <button type="reset" class="btn btn-reset w-50">پاک کرد فرم</button>
    </b-col>
    <b-col cols="6">
      <button type="submit" class="btn btn-success w-50">ثبت</button>
    </b-col>
    <div class="col-6">
        <div class="inner-main">
            <div class="inner-header">
                <div class="row">
                    <div class="col-12">
                        <span>فرم</span>
                    </div>
                </div>
            </div>
            <div class="inner-body row row-eq-height">
                <div class="col-12">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inner-body row row-eq-height">
                <div class="col-12">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inner-body row row-eq-height">
                <div class="col-12">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="inner-main">
            <div class="inner-header">
                <div class="row">
                    <div class="col-12">
                        <span>فرم</span>
                    </div>
                </div>
            </div>
            <div class="inner-body row row-eq-height">
                <div class="col-12">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="inner-main">
            <div class="inner-header">
                <div class="row">
                    <div class="col-12">
                        <span>فرم</span>
                    </div>
                </div>
            </div>
            <div class="inner-body row row-eq-height">
                <div class="col-6">
                    <div class="form-group row align-items-center">
                        <label class="col-2 col-form-label">عنوان ورودی</label>
                        <div class="col-7">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row align-items-center">
                        <label class="col-2 col-form-label">عنوان ورودی</label>
                        <div class="col-7">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="inner-main">
            <div class="inner-header">
                <div class="row">
                    <div class="col-12">
                        <span>فرم</span>
                    </div>
                </div>
            </div>
            <div class="inner-body row row-eq-height">
                <div class="col-6">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="inner-main">
            <div class="inner-header">
                <div class="row">
                    <div class="col-12">
                        <span>فرم</span>
                    </div>
                </div>
            </div>
            <div class="inner-body row row-eq-height">
                <div class="col-6">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="inner-main">
            <div class="inner-header">
                <div class="row">
                    <div class="col-12">
                        <span>فرم</span>
                    </div>
                </div>
            </div>
            <div class="inner-body row row-eq-height">
                <div class="col-6">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row align-items-center">
                        <label class="col-3 col-form-label">عنوان ورودی</label>
                        <div class="col-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-3">
                          <button type="reset" class="col-12 btn btn-primary">ثبت</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
</template>

<script>
import Body from "../../components/portal/Body";

export default {
  name: "DashboardPortal",

  components: {
    Body,
  },

  beforeCreate () {
    if (!this.$store.getters.isAuthenticated) {
      this.$router.push('/portal/login')
    }else{
      if(this.$store.getters.isType != "admin"){
        // this.$store.dispatch('logout');
        // this.$router.push('/portal/login')
      }
    }
  },
  computed: {
    isType: function () {
      return this.$store.getters.isType
    }
  }
};
</script>

