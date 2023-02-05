import './dashboardProfile.scss';
import React, {useEffect} from 'react';
import {useDispatch, useSelector} from "react-redux";
import {selectUser, updateUserData, updateUserPicture} from "../../features/user/userSlice";
import {useForm} from "react-hook-form";
import InputBox from "../commons/InputBox";
import TextareaBox from "../commons/TextareaBox";
import {toast} from "react-toastify";

function DashboardProfile() {
    const user = useSelector(selectUser)
    const {register, handleSubmit, formState: {errors}, setValue} = useForm();
    const dispatch = useDispatch();

    const notify = (type, message) => toast(message, {
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


    const userFields = [
        {
            type: "text",
            name: "fullName",
            value: user?.fullName,
            label: "Nom d'utilisateur",
            register: {
                ...register("fullName", {
                    required: "Le nom d'utilisateur est requis",
                })
            },
        },
        {
            type: "email",
            name: "email",
            value: user?.email,
            label: "Email",
            register: {
                ...register("email", {
                    required: "L'email est requis",
                    pattern: {
                        value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                        message: "L'email n'est pas valide"
                    }
                })
            },

        },
        {
            type: "text",
            name: "job",
            label: "Status (Apprenti ou Mentor)",
            register: {
                ...register("job", {
                    pattern: {
                        value: /^(Apprenti|Mentor)$/,
                        message: "Le status doit être soit 'Apprenti' soit 'Mentor'"
                    },
                })
            },

        },
        {
            type: "file",
            name: "file",
            value: user?.profilPicture ?? "",
            label: "Photo de profil",
            register: {
                ...register("file")
            },
        },
        {
            type: "text",
            name: "city",
            value: user?.city ?? "",
            label: "Ville",
            register: {...register("city")},

        },
        {
            type: "text",
            name: "zipCode",
            value: user?.zipCode ?? "",
            label: "Code postal",
            register: {...register("zipCode")},

        },
        {
            type: "textarea",
            name: "bio",
            value: user?.bio ?? "",
            label: "Mini Bio",
            register: {
                ...register("bio", {
                    maxLength: {
                        value: 500,
                        message: "La mini bio ne doit pas dépasser 500 caractères"
                    },
                })
            },
        }
    ]

    useEffect(() => {
        userFields.forEach(field => {
            setValue(field.name, field.value)
        })
    }, [user])

    const onSubmit = async (data) => {
        try {
            let response = await dispatch(updateUserData({data: data, id: user.id}));

            console.log("response", response)
            if (data.file[0]) {
                const formData = new FormData();
                formData.append("file", data.file[0]);
                response = await dispatch(updateUserPicture({data: formData, id: user.id}));
            }

            console.log("response 2", response)

            const {status} = response.payload;

            if (status === 200) {
                notify("success", "Votre profil a bien été mis à jour")
            }

        } catch (error) {
            console.log(error);
        }
    }

    return (
        <div className="dashboard__profile">
            <div className="profileContent__header">
                <h3>Edition</h3>
                <p>Modifier votre profil selon vos besoins</p>
            </div>
            <form className="dashboard__profileForm" onSubmit={handleSubmit(onSubmit)} encType="multipart/form-data">
                {userFields.map((field, index) => field.type !== "textarea" ?
                    <InputBox
                        key={index}
                        type={field.type}
                        label={field.label}
                        register={{
                            ...register(field.name)
                        }}
                        error={errors[field.name]}
                    />
                    : <TextareaBox
                        key={index}
                        label={field.label}
                        register={{
                            ...register(field.name)
                        }}
                        error={errors[field.name]}
                    />
                )}
                <input type="submit" value="Valider"/>
            </form>
        </div>
    );
}

export default DashboardProfile;