import React, {useEffect} from 'react';
import {ToastContainer, toast} from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

function Notification({type, message}) {

    const notify = () => toast(message[0], {
        position: "top-right",
        autoClose: 5000,
        hideProgressBar: false,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        progress: undefined,
        theme: "dark",
        type: type
    });

    useEffect(() => {
        notify();
    }, [message]);

    return (
        <ToastContainer/>
    );
}

export default Notification;