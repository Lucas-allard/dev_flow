import React, {useEffect, useState} from 'react';
import './sidebar.scss'
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import SidebarChannels from "./SidebarChannels";
import {selectUser} from "../features/user/userSlice";
import {useSelector} from "react-redux";
import {db} from "../../firebase";
import {onSnapshot, query, collection, addDoc, orderBy} from "firebase/firestore";
import Avatar from "@mui/material/Avatar";
import AddIcon from "@mui/icons-material/Add";

const Sidebar = () => {
    const user = useSelector(selectUser);
    const [categoriesChannels, setCategoriesChannels] = useState([]);
    const admin = user?.roles.includes('ROLE_ADMIN');

    const getCategoriesChannels = async () => {

        const q = query(
            collection(db, `categoriesChannels`),
            orderBy("timestamp", "asc")
        );
        onSnapshot(q, (querySnapshot) => {
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

    useEffect(() => {
        getCategoriesChannels()
    }, [])

    const handleAddCategoryChannel = async () => {
        const category = prompt('Saisir le nom de la nouvelle catégorie de channel')
        try {
            const docRef = await addDoc(collection(db, "categoriesChannels"), {
                name: category,
                timestamp: new Date()
            });

            console.log("Document written with ID: ", docRef.id);
        } catch (e) {
            console.error("Error adding document: ", e);
        }
    }

    return (
        <div className="sidebar">
            <div className="sidebar__top">
                <h3>Labo Chat</h3>
                {admin && <AddIcon className="sidebar__addChannel" onClick={handleAddCategoryChannel}/>}
                <ExpandMoreIcon/>
            </div>

            <div className="sidebar__middle">
                {categoriesChannels.map((category, id) =>
                    <SidebarChannels
                        categoryName={category.name}
                        categoryId={category.id}
                        key={category.id}
                    />
                )}
            </div>

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