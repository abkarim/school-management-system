import { useState } from "react";
import showImg from "./../../img/show.png";
import hideImg from "./../../img/hide.png";

export default function PasswordInput({ ...props }) {
  const [type, setType] = useState("password");
  const [img, setImg] = useState(showImg);
  /**
   * toggle password
   */
  const togglePassword = () => {
    if (type === "password") {
      setImg(hideImg);
      return setType("text");
    }
    setImg(showImg);
    setType("password");
  };

  return (
    <div className="relative">
      <input
        type={type}
        className="bg-slate-100 border-gray-500  border-2 p-1 rounded-sm w-full focus:border-gray-800 text-lg text-gray-900"
        {...props}
      />
      <span
        onClick={togglePassword}
        className="inline-block absolute top-0 right-1 p-1 cursor-pointer"
      >
        <img alt="toggle" src={img} />
      </span>
    </div>
  );
}
