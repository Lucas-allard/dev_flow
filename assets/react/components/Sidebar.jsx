import React, {useEffect, useState} from 'react';
import './sidebar.scss'
import KeyboardArrowLeftIcon from '@mui/icons-material/KeyboardArrowLeft';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import SidebarChannels from "./SidebarChannels";
import {selectUser} from "../features/user/userSlice";
import {useDispatch, useSelector} from "react-redux";
import {onSnapshot} from "firebase/firestore";
import Avatar from "@mui/material/Avatar";
import AddIcon from "@mui/icons-material/Add";
import categoriesChannelsAPI from "../services/categoriesChannelsAPI";
import {setIsSelectPrivateMessage} from "../features/privateMessage/privateMessageSlice";

const Sidebar = () => {
    const user = useSelector(selectUser);
    const dispatch = useDispatch();
    const [categoriesChannels, setCategoriesChannels] = useState([]);
    const [expandCategories, setExpandCategories] = useState(false);
    const [expandPrivateChat, setExpandPrivateChat] = useState(false);
    const admin = user?.roles.includes('ROLE_ADMIN');

    useEffect(() => {
        getCategoriesChannels()
    }, [])

    const getCategoriesChannels = async () => {
        onSnapshot(categoriesChannelsAPI.getCategoriesChannels(), (querySnapshot) => {
            setCategoriesChannels([]);
            querySnapshot.forEach((doc) => {
                setCategoriesChannels(
                    (category) => [
                        ...category,
                        {
                            id: doc.id,
                            name: doc.data().name
                        }
                    ]
                )
            });
        });
    }

    const handleAddCategoryChannel = async () => {
        const category = prompt('Saisir le nom de la nouvelle catégorie de channel')
        try {
            await categoriesChannelsAPI.addCategoryChannel(category)
        } catch (e) {
            console.error("Error adding document: ", e);
        }
    }

    return (
        <div className="sidebar">
            <div className="sidebar__top" onClick={() => setExpandCategories(!expandCategories)}>
                <h3>Labo Chat</h3>
                {admin && <AddIcon className="sidebar__addChannel" onClick={handleAddCategoryChannel}/>}
                {!expandCategories &&
                    <KeyboardArrowLeftIcon/>
                }
                {expandCategories &&
                    <KeyboardArrowDownIcon/>
                }
            </div>
            {expandCategories &&
                <div className="sidebar__topOuter">
                    {categoriesChannels.map((category) =>
                        <SidebarChannels
                            categoryName={category.name}
                            categoryId={category.id}
                            key={category.id}
                        />
                    )}
                </div>
            }
            <div className="sidebar__top" onClick={() => setExpandPrivateChat(!expandPrivateChat)}>
                <h3>Messages Privées</h3>
                <AddIcon
                    className="sidebar__addChannel"
                    onClick={(event) => {
                        event.stopPropagation();
                        dispatch(setIsSelectPrivateMessage(true));
                    }}
                />
                {!expandPrivateChat &&
                    <KeyboardArrowLeftIcon/>
                }
                {expandPrivateChat &&
                    <KeyboardArrowDownIcon/>
                }
            </div>
            {expandPrivateChat &&
                <div className="sidebar__topOuter">
                    {categoriesChannels.map((category) =>
                        <SidebarChannels
                            categoryName={category.name}
                            categoryId={category.id}
                            key={category.id}
                        />
                    )}
                </div>
            }

            {user &&
                <div className="sidebar__profile">

                    {user.profilPicture ?
                        <Avatar alt="profil picture" src={user.profilPicture}/>
                        :
                        <div className="sidebar__avatar">
                            <p>{user.fullname[0].toUpperCase()}</p>
                        </div>
                    }
                    <div className="sidebar__profileInfo">
                        <h3>{user.fullname}</h3>
                        {/*<p>#{user.id.substring(0, 8)}</p>*/}
                    </div>
                </div>
            }
        </div>
    );
}

export default Sidebar;