<template>
  <form class="auth-form" method="post" @submit.prevent="submitForm">
    <h1 class="auth-form__title">Добро пожаловать</h1>
    <legend class="auth-form__legend">
      Чтобы войти, введите логин и пароль
    </legend>
    <label class="auth-form__label">
      <input
        v-model="login"
        class="auth-form__input"
        :class="{
          'auth-form__input--invalid': error,
        }"
        type="text"
        name="login"
        id="login"
        placeholder="Введите логин"
        required
      />
    </label>
    <label class="auth-form__label">
      <input
        v-model="password"
        class="auth-form__input"
        :type="isPassShown ? 'text' : 'password'"
        :class="{
          'auth-form__input--invalid': error,
        }"
        name="password"
        id="password"
        placeholder="Введите пароль"
        required
      />
      <button
        class="auth-form__show-password"
        type="button"
        @click="togglePass"
      >
        <span class="visually-hidden">Показать пароль</span>
        <SvgIcon
          :name="isPassShown ? 'close' : 'open'"
          className="auth-form__icon"
        />
      </button>
      <button class="auth-form__forgot-password" type="button">
        Забыли пароль?
      </button>
      <p v-if="error" class="auth-form__error-text">{{ error.message }}</p>
    </label>
    <button
      class="auth-form__submit button"
      type="submit"
      @submit.prevent="submitForm"
    >
      Войти
    </button>
  </form>
</template>
<script>
export default {
  data() {
    return {
      login: '',
      password: '',
      isPassShown: false,
    }
  },
  computed: {
    error() {
      return this.$store.getters['error']
    },
  },
  methods: {
    togglePass() {
      this.isPassShown = !this.isPassShown
    },
    submitForm() {
      this.$store
        .dispatch('authenticate', {
          name: this.login,
          password: this.password,
        })
        .then(
          () => this.$router.push({ name: 'Home' }),
          (e) => {
            console.log(e)
          },
        )
    },
  },
}
</script>
