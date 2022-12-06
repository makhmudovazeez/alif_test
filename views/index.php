<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Alif Test</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>

<div class="container" id="booking">
    <div class="card mt-5">
        <div class="card-header">Form for booking rooms</div>
        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullname">Fullname</label>
                            <input type="text" name="fullname" class="form-control" v-model="full_name"
                                   placeholder="Fullname">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" v-model="email"
                                   placeholder="Email">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from_date">From date</label>
                            <input type="datetime-local" class="form-control" id="from_date" v-model="from_date"
                                   name="from_date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to_date">To date</label>
                            <input type="datetime-local" class="form-control" id="to_date" v-model="to_date"
                                   name="to_date">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rooms">Rooms</label>
                            <select name="rooms" id="rooms" class="form-control" v-model="room_id">
                                <option v-for="v in room_options" :value="v.id">{{ v.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <div class="form-group">
                    <button class="btn btn-success">Book</button>
                </div>
            </div>
        </div>
    </div>
    <template v-if="booked_rooms.length > 0">
        <div class="card mt-4">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fullname</th>
                        <th scope="col">Email</th>
                        <th scope="col">From Date</th>
                        <th scope="col">To Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(br, index) in booked_rooms">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ br.full_name }}</td>
                        <td>{{ br.email }}</td>
                        <td>{{ br.from_date }}</td>
                        <td>{{ br.to_date }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </template>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script>
    new Vue({
        el: "#booking",
        data: {
            host: window.location.host,
            full_name: null,
            email: null,
            room_id: null,
            from_date: null,
            to_date: null,
            room_options: [],
            booking_options: [],
            booked_rooms: [],
        },
        mounted() {
            const vm = this

            fetch('/get-rooms')
                .then(response => response.json())
                .then(data => {
                    vm.room_options = data
                }).catch(err => console.log(err))
        },
        methods: {
            submit() {

            },
            getBookedRooms(room_id, from_date, to_date) {
                if (!room_id || !from_date || !to_date){
                    return
                }
                const vm = this
                let url = `/get-booked-room?room_id=${room_id}&from_date=${from_date}&to_date=${to_date}`

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        vm.booked_rooms = data
                    })
            }
        },
        watch: {
            'room_id'() {
                this.getBookedRooms(this.room_id, this.from_date, this.to_date)
            },
            'from_date'() {
                this.getBookedRooms(this.room_id, this.from_date, this.to_date)
            },
            'to_date'() {
                this.getBookedRooms(this.room_id, this.from_date, this.to_date)
            }
        }
    })
</script>
</body>
</html>