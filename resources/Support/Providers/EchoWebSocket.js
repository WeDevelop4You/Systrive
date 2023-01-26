import Echo from 'laravel-echo';
import Pusher from "pusher-js";

window.Pusher = Pusher

class EchoWebSocket {
    constructor(app) {
        this.#create(app)
    }

    #create(app) {
        app.$echo = new Echo({
            broadcaster: 'pusher',
            key: import.meta.env.VITE_PUSHER_APP_KEY,
            wsHost: import.meta.env.VITE_PUSHER_APP_HOST,
            cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
            authorizer: (channel) => {
                return {
                    authorize: (socketId, callback) => {
                        app.$api.call({
                            url: app.$api.route('misc.broadcast.auth'),
                            method: 'POST',
                            data: {
                                socket_id: socketId,
                                channel_name: channel.name
                            }
                        }).then(response => {
                            callback(false, response.data);
                        }).catch(error => {
                            callback(true, error);
                        });
                    }
                };
            },
        })
    }
}

export default EchoWebSocket

