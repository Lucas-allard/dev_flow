import React, {useEffect} from 'react';
import {ToastContainer, toast} from 'react-toastify';

function Notification({type, message}) {

    const notify = () => toast(message[0]);

    useEffect(() => {
        notify();
    }, [message]);

    return (
        <div className={`alert alert-${type}`}>
            <ToastContainer
                position="top-right"
                autoClose={5000}
                hideProgressBar={false}
                newestOnTop={false}
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover
                theme="light"
            />
            {/* Same as */}
            <ToastContainer/>
        </div>
    );
}

export default Notification;