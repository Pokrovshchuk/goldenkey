<template>
  <div class="connection-status" v-if="isOffline">
    <button class="connection-status__toggle-button">
      <span class="visually-hidden">Соединение отсутствует</span>
    </button>
    <div class="connection-status__popup">
      <div class="connection-status__window">
        <h2
          class="connection-status__title"
          :class="{ 'connection-status__title--wide': !tryToConnect }"
        >
          {{
            tryToConnect
              ? 'Отсутствует интернет или связь с сервером'
              : 'Мы не смогли установить связь с сервером'
          }}
        </h2>

        <p v-if="tryToConnect" class="connection-status__count">
          Пытаемся установить соединение
          <span class="connection-status__time">{{ timeToCall }}</span>
        </p>
        <p v-if="!tryToConnect" class="connection-status__text">
          Для проверки статуса сертификата позвоните по указанному номеру
          телефона и назовите номер сертификата — мы активируем его вручную.
        </p>

        <p v-if="!tryToConnect" class="connection-status__text">
          После восстановления связи запись о гашении сертификата будет
          размещена в реестре автоматически.
        </p>
        <!-- <div v-if="!tryToConnect" class="connection-status__phone">
          <span class="connection-status__phone-number">+7 982 565 45 67</span>
          <a
            class="button connection-status__phone-button"
            href="tel:+79825654567"
            >Позвонить</a
          >
        </div> -->
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      isOffline: false,
      timeToCall: 30,
      intervalId: null,
    }
  },
  mounted() {
    const setOnline = this.setOnline 
    const setOffline = this.setOffline 
    window.addEventListener('offline', this.setOffline)
    window.addEventListener('online', this.setOnline)
    this.$axios.interceptors.response.use(function (response) {
      setOnline()
      return response
    }, function (error) {
      if (error.code >= 500 && error.code < 600) {
        setOffline()
      }
      return error;
    });

    this.intervalId = setInterval(this.decrementTimeToCall, 1000)
  },
  beforeDestroy() {
    window.removeEventListener('offline', this.setOffline)
    window.removeEventListener('online', this.setOnline)
    clearInterval(this.intervalId)
    this.timeToCall = 30
  },
  methods: {
    setOnline() {
      this.timeToCall = 30
      this.isOffline = false
    },
    setOffline() {
      this.timeToCall = 30
      this.isOffline = true
    },
    decrementTimeToCall() {
      if (this.timeToCall >= 0) {
        this.timeToCall = this.timeToCall - 1
      }
    },
  },
  computed: {
    tryToConnect() {
      return this.timeToCall >= 0
    },
  },
}
</script>

<style lang="scss" scoped>
.connection-status {
  width: 24px;
  height: 24px;
  margin-top: 50px;
  margin-right: 40px;
  border: none;
  background-color: transparent;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M19.5 9.75a6.682 6.682 0 01-1.894 4.675l1.06 1.06A8.235 8.235 0 0017.7 3.15l-.902 1.2a6.7 6.7 0 012.7 5.4z' fill='%239096A0'%3E%3C/path%3E%3Cpath d='M15.75 9.75a3.751 3.751 0 01-.677 2.142l1.07 1.071a5.238 5.238 0 00-.643-7.126l-1 1.118a3.756 3.756 0 011.25 2.795zm6.75 11.69L2.56 1.5 1.5 2.56l2.782 2.783A8.236 8.236 0 006.3 16.351l.9-1.2a6.726 6.726 0 01-1.821-8.712l1.648 1.647A5.225 5.225 0 008.5 13.663l1-1.118A3.754 3.754 0 018.25 9.75c.002-.137.012-.274.03-.41l2.97 2.97V22.5h1.5v-8.69l8.69 8.69 1.06-1.06z' fill='%239096A0'%3E%3C/path%3E%3C/svg%3E");
  position: relative;
  &__toggle-button {
    position: absolute;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: transparent;
    border: none;
  }
  &__popup {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(#1b1d21, 0.5);
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: initial;
  }
  &__window {
    width: 435px;

    background: #ffffff;
    border-radius: 6px;
    background-image: url("data:image/svg+xml,%3Csvg width='67' height='67' viewBox='0 0 67 67' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.4375 27.2188C54.4484 32.0932 52.5508 36.7783 49.1508 40.2712L52.1093 43.2297C54.3892 40.8871 56.1434 38.0852 57.2547 35.011C58.366 31.9368 58.8089 28.6609 58.5539 25.402C58.2989 22.143 57.3518 18.9759 55.7758 16.112C54.1998 13.2481 52.0312 10.7532 49.4146 8.79375L46.8979 12.1437C49.2469 13.891 51.1529 16.1653 52.4624 18.7837C53.7719 21.402 54.4485 24.2912 54.4375 27.2188Z' fill='%239096A0'/%3E%3Cpath d='M43.9688 27.2187C43.9648 29.3581 43.3057 31.4449 42.0802 33.1985L45.068 36.1884C47.3472 33.263 48.4297 29.5809 48.0961 25.8874C47.7626 22.194 46.038 18.7653 43.2716 16.2957L40.4785 19.4153C41.5757 20.3979 42.4536 21.6007 43.055 22.9452C43.6564 24.2897 43.9677 25.7459 43.9688 27.2187Z' fill='%239096A0'/%3E%3Cpath d='M62.8125 59.8519L7.14806 4.1875L4.1875 7.14806L11.9553 14.9159C8.85112 19.8058 7.70674 25.6872 8.75091 31.3843C9.79508 37.0814 12.9509 42.1746 17.5875 45.6458L20.1 42.2958C16.4351 39.5572 13.8962 35.5747 12.9601 31.0964C12.0241 26.6181 12.7553 21.9521 15.0164 17.9748L19.6163 22.5748C18.6981 25.2867 18.5984 28.209 19.3297 30.9772C20.0609 33.7454 21.5907 36.2371 23.7285 38.1418L26.5215 35.0222C25.4242 34.0396 24.5463 32.8369 23.9449 31.4924C23.3435 30.1478 23.0322 28.6917 23.0312 27.2188C23.0378 26.8364 23.0657 26.4548 23.115 26.0756L31.4062 34.3668V62.8125H35.5938V38.5543L59.8519 62.8125L62.8125 59.8519Z' fill='%239096A0'/%3E%3C/svg%3E%0A");
    background-repeat: no-repeat;
    background-position: center 40px;

    padding-top: 127px;
    padding-bottom: 40px;
  }
  &__title {
    width: 290px;
    margin: 0 auto;
    margin-bottom: 28px;
    text-align: center;

    &--wide {
      width: 279px;
    }
  }
  &__count {
    width: 320px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 12px;
    line-height: 140%;
    color: #9096a0;
  }
  &__time {
    background: #eff1f3;
    border-radius: 5px;
    width: 91px;
    height: 41px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: 500;
    font-size: 24px;
    line-height: 29px;
    color: #1b1d21;
    margin-top: 25px;
  }
  &__text {
    width: 375px;
    margin: 0 auto;
    margin-bottom: 20px;
    font-family: 'Inter', sans-serif;
    font-style: normal;
    font-weight: normal;
    font-size: 12px;
    line-height: 140%;
    text-align: center;
    color: #1b1d21;
  }

  &__phone {
    width: 375px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    padding-left: 15px;
    justify-content: space-between;
    background-color: #f4f8fc;
    border: 1px solid #eff1f3;
    box-sizing: border-box;
    border-radius: 6px;
    font-family: Inter;
    font-style: normal;
    font-weight: 500;
    font-size: 20px;
    line-height: 24px;
    text-align: center;

    user-select: all;
    color: #366ace;
  }
  &__phone-button {
    padding-right: 40px;
    padding-left: 40px;
  }
}
</style>
