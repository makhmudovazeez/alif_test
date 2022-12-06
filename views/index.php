<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Alif Test</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>

<div class="container">
    <div class="card mt-5">
        <div class="card-header">Form for booking rooms</div>
        <div class="card-body">
            <form id="booking-form" @submit.prevent="submit">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullname">Fullname</label>
                            <input type="text" name="fullname" class="form-control" v-model="full_name" placeholder="Fullname">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" v-model="email" placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from_date">From date</label>
                            <input type="datetime-local" class="form-control" id="from_date" v-model="from_date" name="from_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to_date">To date</label>
                            <input type="datetime-local" class="form-control" id="to_date" v-model="to_date" name="to_date">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rooms">Rooms</label>
                            <select name="rooms" id="rooms" class="form-control" v-model="room">
                                <option v-for="v in room_options" :value="v.id">{{ v.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="form-group">
                        <button class="btn btn-success">Book</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    new Vue({
        el: "#booking-form",
        data: {
            host: window.location.host,
            full_name: null,
            email: null,
            room: null,
            from_date: null,
            to_date: null,
            room_options: [],
            booking_options: [],
            booked_rooms: [],
        },
        mounted() {
            const vm = this
        },
        methods: {
            submit() {

            }
        },
        watch: {
            'room' () {

            }
        }
    })
</script>
</body>
</html>