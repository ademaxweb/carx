<template>
  <div>
      <h1 class="block_header">Главная</h1>
      <div class="container">
          <p>CarX - веб. сайт, на котором ты можешь собрать свою собственную коллекцию автомобилей, начиная от невзрачных бюджетных авто прошлого века и заканчивая современным суперкарами</p>
      </div>

      <div class="container container--line container--center container--padding">
          <div class="container container--card">
              <font-awesome-icon icon="fa-solid fa-money-bill-wave"  class="card-icon"/>
              <h3>Собирай, покупай, продавай</h3>
          </div>
          <div class="container container--card">
              <font-awesome-icon icon="fa-solid fa-suitcase"  class="card-icon"/>
              <h3>Открывай кейсы</h3>
          </div>
          <div class="container container--card">
              <font-awesome-icon icon="fa-solid fa-globe" class="card-icon"/>
              <h3>Соревнуйся с другими</h3>
          </div>
      </div>

      <h2 class="block_heading">Как собрать свою коллекцию?</h2>
      <div class="container">
          <h3 class="p-heading">Регистрация</h3>
          <p>Создавай аккаунт, перейдя на страницу авторизации, пройди обучение и получи свою первую машину!</p>

          <h3 class="p-heading">Магазин</h3>
          <p>В магазине ты можешь купить любой интересующий тебя автомобиль, загляни!</p>

          <h3 class="p-heading">Кейсы</h3>
          <p>Открывая кейсы, ты можешь получить дорогое авто гораздо ниже его стоимости. Но не забывай о рисках, всё зависит от твоей удачи.<br>Если ты готов рискнуть, то скорее заглядывай на страницу с кейсами!</p>
      </div>

  </div>
</template>

<script>
import itemCard from "../components/UI/item-card.vue";
export default {
    name: "Home",
    components: {itemCard}

}
</script>

<style lang="scss" scoped>
    @import "./../../sass/vairables";
    .container{
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;

        &--padding{
            padding: 50px 0;
        }

        & .block_heading{
            font-size: 38px;
            margin-bottom: 25px;
        }

        & .p-heading{
            font-size: 24px;
            margin-bottom: 5px;
        }
        & p{
            font-size: 18px;
            margin-bottom: 25px;
            &:last-child{
                margin-bottom: 0;
            }
        }

        &--card{
            width: 300px;
            min-height: 300px;
            background-color: $color-5;
            padding: 25px 15px;
            border-radius: $border-radius-base;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            & .card-icon{
                width: 50px;
                height: 50px;
                margin-bottom: 25px;
            }

            border: 3px solid $color-2;
            box-shadow: 0 0 25px $color-2;

        }



        &--line{
            flex-direction: row;
            &.container--center{
                justify-content: space-around;
            }

            @media screen and (max-width: $content-width-3){
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                & > *{
                    max-width: 100%;
                    margin-top: 25px;
                    &:first-child{
                        margin-top: 0;
                    }
                }
            }
        }
    }
</style>
