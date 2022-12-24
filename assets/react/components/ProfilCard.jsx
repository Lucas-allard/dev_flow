import './profilCard.scss';
import React, {useState} from 'react';
import ChatInput from "./ChatInput";
import moment from "moment/moment";
import {useDispatch, useSelector} from "react-redux";
import {selectUser} from "../features/user/userSlice";
import privatesMessagesChannelsAPI from "../services/privatesMessagesChannelsAPI";
import {setChannel} from "../features/channel/channelSlice";

function ProfilCard({userProfil, setIsActiveProfilCard}) {
    const user = useSelector(selectUser)
    const dispatch = useDispatch()
    const [input, setInput] = useState("");

    const sendMessage = async () => {
        const data = {
            from: user.fullname,
            to: userProfil.fullname,
            participants: [user.fullname, userProfil.fullname],
            message: input,
            user: user,
            collection: "privatesMessages"
        };
        try {
            const {status} = await privatesMessagesChannelsAPI.addMessage(user, data)
            if (status === 201) {
                setInput('');
                setIsActiveProfilCard(false)
                dispatch(setChannel({
                    sender: userProfil.fullname,
                }))
            }
        } catch (e) {
            console.error("Error adding document: ", e);
        }
    }

    return (
        <div className="profil__card">
            <div
                className="profil__cardHeader"
                style={{backgroundColor: userProfil.profilColor ? userProfil.profilColor : null}}
            ></div>
            <div className="profil__cardContent">
                <h3>{userProfil.fullname}</h3>
                <div className="profil__cardCreatedAt">
                    <p>Membre depuis</p>
                    <p><em>{moment(userProfil.createdAt.date).locale("fr").format("ll")}</em></p>
                </div>
                <div className="profil__cardRoles">
                    <p>Rôles</p>
                </div>
                <ChatInput
                    classname="profil__cardInput"
                    input={input}
                    setInput={setInput}
                    sendMessage={sendMessage}
                />
            </div>
        </div>
    );
}

export default ProfilCard;