import React, {useEffect, useState} from 'react';
import './sidebarChannels.scss';
import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import AddIcon from "@mui/icons-material/Add";
import {addDoc, collection, getDocs, onSnapshot, orderBy, query} from "firebase/firestore";
import {db} from "../../firebase";
import SidebarChannel from "./SidebarChannel";
import {useDispatch, useSelector} from "react-redux";
import {setChannel} from "../features/channel/channelSlice";
import {selectUser} from "../features/user/userSlice";


const SidebarChannels = ({categoryName, categoryId}) => {
    const [channels, setChannels] = useState([]);
    const dispatch = useDispatch();
    const user = useSelector(selectUser);
    const admin = user?.roles.includes('ROLE_ADMIN');


    const getChannels = async () => {
        const q = query(
            collection(db, `categoriesChannels/${categoryId}/channels`),
            orderBy("timestamp", "asc")
        );
        onSnapshot(q, (querySnapshot) => {
            setChannels([]);
            querySnapshot.forEach((doc) => {
                setChannels(
                    (channel) => [
                        ...channel,
                        {
                            id: doc.id,
                            name: doc.data().name
                        }
                    ]
                )
            });
        });
    }

    useEffect(() => {
        getChannels()
    }, [])

    const handleAddChannel = async (categoryId) => {
        const channel = prompt('Saisir de le nom du nouveau channel');
        try {
            const docRef = await addDoc(collection(db, `categoriesChannels/${categoryId}/channels`), {
                name: channel,
                timestamp: new Date()
            })

            console.log("Document written with ID: ", docRef.id);
        } catch (e) {
            console.error("Error adding document: ", e);
        }
    }

    const handleChangeChannel = (channelName, channelId) => {
        dispatch(setChannel({
            channelId: channelId,
            channelName: channelName,
            categoryId: categoryId
        }))
    }

    return (
        <div className="sidebar__channels">
            <div className="sidebar__channelsHeader">
                <div className="sidebar__header">
                    <ExpandMoreIcon/>
                    <h4>{categoryName}</h4>
                </div>
                {admin && <AddIcon className="sidebar__addChannel" onClick={() => handleAddChannel(categoryId)}/>}
            </div>

            <div className="sidebar__channelsList">
                {channels && channels.map((channel) =>
                    <SidebarChannel
                        channelName={channel.name}
                        id={channel.id}
                        onHandleChangeChannel={handleChangeChannel}
                        key={channel.id}
                    />
                )}

            </div>
        </div>
    );
}

export default SidebarChannels;