import Echo from "laravel-echo";
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});

$(document).ready(function() {
      if(userID) {
          window.Echo.private(`order.${userID}`)
          .notification((notification) => {
                showNotifications(notification, '#notifications');
                var notificationsWrapper = $('.dropdown-notifications');
                var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
                var notificationsCountElem = notificationsToggle.find('i[data-count]');
                var notificationsCount = parseInt(notificationsCountElem.data('count'));
                notificationsCount += 1;
                notificationsCountElem.attr('data-count', notificationsCount);
            });
    }
  
});

function showNotifications(notification, target) {
    if(notification.data) {  
        $(target).prepend(makeNotification(notification));
    }
}

// Make a single notification string
function makeNotification(notification) {
    var locale = document.documentElement.lang ;
    if (locale == 'vi') {
        if (notification.data.status_order == 1) {
           return `<a
            href="${notification.data.link}?read=${notification.id}">
            <li class="notification active">
                <div class="media">
                    <div class="media-left">
                    </div>
                    <div class="media-body">
                        <strong
                            class="notification-title">
                            Cập nhật trạng thái đơn hàng:
                            #${notification.data.order_code}</strong>
                        <div
                            class="notification-meta">
                            <small
                                class="timestamp">
                                Đơn hàng đã được chấp nhận vào lúc ${notification.data.time}
                            </small>
                            <span class="dot unread-color"></span>
                        </div>
                    </div>
                </div>
            </li>
            </a>`;
        } else {
            return `<a
            href="${notification.data.link}?read=${notification.id}">
            <li class="notification active">
                <div class="media">
                    <div class="media-left">
                    </div>
                    <div class="media-body">
                        <strong
                            class="notification-title">
                            Cập nhật trạng thái đơn hàng:
                            #${notification.data.order_code}</strong>
                        <div
                            class="notification-meta">
                            <small
                                class="timestamp">
                                Đơn hàng đã bị hủy vào lúc ${notification.data.time}
                            </small>
                            <span class="dot unread-color"></span>
                        </div>
                    </div>
                </div>
            </li>
            </a>`;
        }
    } else {
        if(notification.data.status_order == 1){
            return `<a
             href="${notification.data.link}?read=${notification.id}">
             <li class="notification active">
                 <div class="media">
                     <div class="media-left">
                     </div>
                     <div class="media-body">
                         <strong
                             class="notification-title">
                             Order status update:
                             #${notification.data.order_code}</strong>
                         <div
                             class="notification-meta">
                             <small
                                 class="timestamp">
                                 The order has been accepted at ${notification.data.time}
                             </small>
                             <span class="dot unread-color"></span>
                         </div>
                     </div>
                 </div>
             </li>
             </a>`;
         } else {
             return `<a
             href="${notification.data.link}?read=${notification.id}">
             <li class="notification active">
                 <div class="media">
                     <div class="media-left">
                     </div>
                     <div class="media-body">
                         <strong
                             class="notification-title">
                             Order status update:
                             #${notification.data.order_code}</strong>
                         <div
                             class="notification-meta">
                             <small
                                 class="timestamp">
                                 The order was canceled at ${notification.data.time}
                             </small>
                             <span class="dot unread-color"></span>
                         </div>
                     </div>
                 </div>
             </li>
             </a>`;
         }
    }
}
