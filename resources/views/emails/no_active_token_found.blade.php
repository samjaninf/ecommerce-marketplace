@extends('emails._main')

@section('mail')
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    ﻿<!doctype html>
    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
        <head>
            <!-- NAME: 1 COLUMN - BANDED -->
            <!--[if gte mso 15]>
            <xml>
                <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
                </o:OfficeDocumentSettings>
            </xml>
            <![endif]-->
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>*|MC:SUBJECT|*</title>
            
        <style type="text/css">
            p{
                margin:0px 0;
                padding:0;
            }
            table{
                border-collapse:collapse;
            }
            h1,h2,h3,h4,h5,h6{
                display:block;
                margin:0;
                padding:0;
            }
            img,a img{
                border:0;
                height:auto;
                outline:none;
                text-decoration:none;
            }
            body,#bodyTable,#bodyCell{
                height:100%;
                margin:0;
                padding:0;
                width:100%;
            }
            #outlook a{
                padding:0;
            }
            img{
                -ms-interpolation-mode:bicubic;
            }
            table{
                mso-table-lspace:0pt;
                mso-table-rspace:0pt;
            }
            .ReadMsgBody{
                width:100%;
            }
            .ExternalClass{
                width:100%;
            }
            p,a,li,td,blockquote{
                mso-line-height-rule:exactly;
            }
            a[href^=tel],a[href^=sms]{
                color:inherit;
                cursor:default;
                text-decoration:none;
            }
            p,a,li,td,body,table,blockquote{
                -ms-text-size-adjust:100%;
                -webkit-text-size-adjust:100%;
            }
            .ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
                line-height:100%;
            }
            a[x-apple-data-detectors]{
                color:inherit !important;
                text-decoration:none !important;
                font-size:inherit !important;
                font-family:inherit !important;
                font-weight:inherit !important;
                line-height:inherit !important;
            }
            .templateContainer{
                max-width:600px !important;
            }
            a.mcnButton{
                display:block;
            }
            .mcnImage{
                vertical-align:bottom;
            }
            .mcnTextContent{
                word-break:break-word;
            }
            .mcnTextContent img{
                height:auto !important;
            }
            .mcnDividerBlock{
                table-layout:fixed !important;
            }

            body,#bodyTable{
                /*@editable*/background-color:#FAFAFA;
            }

            #bodyCell{
                /*@editable*/border-top:0;
            }
        
            h1{
                /*@editable*/color:#ff0000;
                /*@editable*/font-family:Helvetica;
                /*@editable*/font-size:26px;
                /*@editable*/font-style:normal;
                /*@editable*/font-weight:bold;
                /*@editable*/line-height:125%;
                /*@editable*/letter-spacing:normal;
                /*@editable*/text-align:left;
            }
        /*
        */
            h2{
                /*@editable*/color:#202020;
                /*@editable*/font-family:Helvetica;
                /*@editable*/font-size:22px;
                /*@editable*/font-style:normal;
                /*@editable*/font-weight:bold;
                /*@editable*/line-height:125%;
                /*@editable*/letter-spacing:normal;
                /*@editable*/text-align:left;
            }

            h3{
                /*@editable*/color:#202020;
                /*@editable*/font-family:Helvetica;
                /*@editable*/font-size:20px;
                /*@editable*/font-style:normal;
                /*@editable*/font-weight:bold;
                /*@editable*/line-height:125%;
                /*@editable*/letter-spacing:normal;
                /*@editable*/text-align:left;
            }

            h4{
                /*@editable*/color:#202020;
                /*@editable*/font-family:Helvetica;
                /*@editable*/font-size:18px;
                /*@editable*/font-style:normal;
                /*@editable*/font-weight:bold;
                /*@editable*/line-height:125%;
                /*@editable*/letter-spacing:normal;
                /*@editable*/text-align:left;
            }

            #templateHeader{
                /*@editable*/background-color:#000000;
                /*@editable*/border-top:0;
                /*@editable*/border-bottom:0;
                /*@editable*/padding-top:0px;
                /*@editable*/padding-bottom:0px;
            }

            #templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
                /*@editable*/color:#202020;
                /*@editable*/font-family:Helvetica;
                /*@editable*/font-size:16px;
                /*@editable*/line-height:150%;
                /*@editable*/text-align:left;
            }
        
            #templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
                /*@editable*/color:#2BAADF;
                /*@editable*/font-weight:normal;
                /*@editable*/text-decoration:underline;
            }

            #templateBody{
                /*@editable*/background-color:#000000;
                /*@editable*/border-top:0;
                /*@editable*/border-bottom:0;
                /*@editable*/padding-top:0px;
                /*@editable*/padding-bottom:0px;
            }
        
            #templateBody .mcnTextContent,#templateBody .mcnTextContent p{
                /*@editable*/color:#202020;
                /*@editable*/font-family:Helvetica;
                /*@editable*/font-size:16px;
                /*@editable*/line-height:150%;
                /*@editable*/text-align:left;
            }
        
            #templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
                /*@editable*/color:#0099ff;
                /*@editable*/font-weight:normal;
                /*@editable*/text-decoration:underline;
            }

            #templateFooter{
                /*@editable*/background-color:#000000;
                /*@editable*/border-top:0;
                /*@editable*/border-bottom:0;
                /*@editable*/padding-top:9px;
                /*@editable*/padding-bottom:9px;
            }

            #templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
                /*@editable*/color:#f2f2f2;
                /*@editable*/font-family:Helvetica;
                /*@editable*/font-size:12px;
                /*@editable*/line-height:150%;
                /*@editable*/text-align:center;
            }

            #templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
                /*@editable*/color:#656565;
                /*@editable*/font-weight:normal;
                /*@editable*/text-decoration:underline;
            }
        @media only screen and (min-width:768px){
            .templateContainer{
                width:600px !important;
            }

    }   @media only screen and (max-width: 480px){
            body,table,td,p,a,li,blockquote{
                -webkit-text-size-adjust:none !important;
            }

    }   @media only screen and (max-width: 480px){
            body{
                width:100% !important;
                min-width:100% !important;
            }

    }   @media only screen and (max-width: 480px){
            #bodyCell{
                padding-top:10px !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnImage{
                width:100% !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnCaptionTopContent,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer{
                max-width:100% !important;
                width:100% !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnBoxedTextContentContainer{
                min-width:100% !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnImageGroupContent{
                padding:9px !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
                padding-top:9px !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnImageCardTopImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
                padding-top:18px !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnImageCardBottomImageContent{
                padding-bottom:9px !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnImageGroupBlockInner{
                padding-top:0 !important;
                padding-bottom:0 !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnImageGroupBlockOuter{
                padding-top:9px !important;
                padding-bottom:9px !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnTextContent,.mcnBoxedTextContentColumn{
                padding-right:18px !important;
                padding-left:18px !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
                padding-right:18px !important;
                padding-bottom:0 !important;
                padding-left:18px !important;
            }

    }   @media only screen and (max-width: 480px){
            .mcpreview-image-uploader{
                display:none !important;
                width:100% !important;
            }

    }   @media only screen and (max-width: 480px){

            h1{
                /*@editable*/font-size:22px !important;
                /*@editable*/line-height:125% !important;
            }

    }   @media only screen and (max-width: 480px){

            h2{
                /*@editable*/font-size:20px !important;
                /*@editable*/line-height:125% !important;
            }

    }   @media only screen and (max-width: 480px){

            h3{
                /*@editable*/font-size:18px !important;
                /*@editable*/line-height:125% !important;
            }

    }   @media only screen and (max-width: 480px){

            h4{
                /*@editable*/font-size:16px !important;
                /*@editable*/line-height:150% !important;
            }

    }   @media only screen and (max-width: 480px){

            .mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
                /*@editable*/font-size:14px !important;
                /*@editable*/line-height:150% !important;
            }

    }   @media only screen and (max-width: 480px){

            #templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
                /*@editable*/font-size:16px !important;
                /*@editable*/line-height:150% !important;
            }

    }   @media only screen and (max-width: 480px){

            #templateBody .mcnTextContent,#templateBody .mcnTextContent p{
                /*@editable*/font-size:16px !important;
                /*@editable*/line-height:150% !important;
            }

    }   @media only screen and (max-width: 480px){

            #templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
                /*@editable*/font-size:14px !important;
                /*@editable*/line-height:150% !important;
            }

    }</style>
                      <script type="text/javascript">
                        var AKSB=AKSB||{};AKSB.q=[];AKSB.mark=function(c,a){AKSB.q.push(["mark",c,a||(new Date).getTime()])};AKSB.measure=function(c,a,b){AKSB.q.push(["measure",c,a,b||(new Date).getTime()])};AKSB.done=function(c){AKSB.q.push(["done",c])};AKSB.mark("firstbyte",(new Date).getTime());
                        AKSB.prof={custid:"358634",ustr:"",originlat:0,clientrtt:36,ghostip:"173.222.211.194",ipv6:false,pct:10,xhrtest:false,clientip:"86.173.236.64",requestid:"12db21bf",protocol:"",blver:2,akM:"b",akN:"ae",akTT:"O",akTX:"1",
                        akTI:"12db21bf"};
                        (function(c){var a=document.createElement("iframe");a.src="javascript:false";(a.frameElement||a).style.cssText="width: 0; height: 0; border: 0; display: none";var b=document.getElementsByTagName("script"),b=b[b.length-1];b.parentNode.insertBefore(a,b);a=a.contentWindow.document;b=String.fromCharCode;c=b(60)+"body onload=\"var js = document.createElement('script');js.id = 'aksb-ifr';js.src = '"+c+"';document.body.appendChild(js);\""+b(62);a.open().write(c);a.close()})(("https:"===document.location.protocol?
                        "https:":"http:")+"//ds-aksb-a.akamaihd.net/aksb.min.js");
                      </script>
                      </head>
        <body>
            <center>
                <table align="center" border="0" cellpadding="-20px" cellspacing="0" height="0%" width="100%" id="bodyTable">
                    <tr>
                                    <td align="center" valign="top" id="templateHeader">
                                        <!--[if gte mso 9]>
                                        <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                        <tr>
                                        <td align="center" valign="top" width="600" style="width:600px;">
                                        <![endif]-->
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                            <tr>
                                                <td valign="top" class="headerContainer"><table class="mcnImageBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody class="mcnImageBlockOuter">
                <tr>
                    <td style="padding:0px" class="mcnImageBlockInner" valign="top">
                        <table class="mcnImageContentContainer" style="min-width:100%;" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr>
                                <td class="mcnImageContent" style="padding-right: 9px; padding-left: 9px; padding-top: 10px; padding-bottom: 10px; text-align:center;" valign="top">
                                    
                                        
                                            <img alt="" src="https://gallery.mailchimp.com/0703726b93d229eadd93c6ffc/images/d8321ab1-d37f-4f06-98ba-5bede53e02db.png" style="max-width:151px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="middle" width="151">
                                        
                                    
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
        </tbody>
    </table><table class="mcnImageBlock" style="min-width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody class="mcnImageBlockOuter">
                <tr>
                    <td style="padding:0px" class="mcnImageBlockInner" valign="top">
                        <table class="mcnImageContentContainer" style="min-width:100%;" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr>
                                <td class="mcnImageContent" style="padding-right: 0px; padding-left: 0px; padding-top: 0; padding-bottom: 0; text-align:center;" valign="top">
                                    
                                        
                                            <img alt="" src="https://gallery.mailchimp.com/0703726b93d229eadd93c6ffc/images/51a7ca98-4678-4f62-bf26-a8e24d0078dc.jpg" style="max-width:940px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage" align="middle" width="600">
                                        
                                    
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
        </tbody>
    </table><table class="mcnBoxedTextBlock" border="0" cellpadding="0" cellspacing="0" style="width: 600px; margin: 0 auto;">
        <!--[if gte mso 9]>
        <table align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
        <![endif]-->
        <tbody class="mcnBoxedTextBlockOuter">
            <tr>
                <td class="mcnBoxedTextBlockInner" valign="top">
                    
                    <!--[if gte mso 9]>
                    <td align="center" valign="top" ">
                    <![endif]-->
                    <table style="min-width:100%;" class="mcnBoxedTextContentContainer" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            
                            <td style="padding-top:0px; padding-left:0px; padding-bottom:0px; padding-right:0px;">
                            
                                <table class="mcnTextContentContainer" style="min-width: 100% ! important;background-color: #2480A5;" border="0" cellpadding="18" cellspacing="0" width="100%">
                                    <tbody><tr>
                                        <td style="color: #F2F2F2;font-family: Helvetica;font-size: 14px;font-weight: bold;text-align: left;" class="mcnTextContent" valign="top">
                                            <span style="font-size:15px"><span style="font-family:trebuchet ms,lucida grande,lucida sans unicode,lucida sans,tahoma,sans-serif">
    Please make sure to activate the phone application to receive orders in time.
@stop
